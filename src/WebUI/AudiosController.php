<?php

namespace App\WebUI;

use App\Audio\Application\Interactor\AudioImporterInterface;
use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Form\AudioImportSourceType;
use App\Player\Application\Interactor\PlayerQueueInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Shared\WebUI\PaginationParamsTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/audios', name: 'audios.')]
class AudiosController extends AbstractController
{
    use PaginationParamsTrait;

    public function __construct(
        private AudioInfoProviderInterface        $audioInfoProvider,
        private PlayerStatusInfoProviderInterface $statusInfoProvider,
        private PlayerQueueInterface              $playerQueue,
        private AudioImporterInterface            $audioImporter
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {

        $status = $this->statusInfoProvider->status();
        $paginationResults = $this->audioInfoProvider->paginateAudios($this->parsePaginationParams($request));
        $nowPlaying = $status->audioPlayStatus->currentPlayingAudio?->audio;

        return $this->render(
            'audio/audio_browser.html.twig',
            [
                'pagination' => $paginationResults,
                'playerStatus' => $status,
                'nowPlaying' => $nowPlaying
            ]
        );
    }

    #[Route('/{id}/queue', name: 'addToPlayingQueue', methods: ['post'])]
    public function addToPlayingQueue(string $id, Request $request): Response
    {
        $audio = $this->audioInfoProvider->findAudio($id);
        $this->playerQueue->add($audio);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->render('audio/playlist_actions_stream.html.twig', [
                'audio' => $audio,
                'queued' => true
            ]);
        }

        return $this->redirectToRoute('audios.index');
    }

    #[Route('/{id}/queue', name: 'removeFromPlayingQueue', methods: ['delete'])]
    public function removeFromPlayingQueue(string $id, Request $request): Response
    {
        $audio = $this->audioInfoProvider->findAudio($id);
        $this->playerQueue->remove($audio);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->render('audio/playlist_actions_stream.html.twig', [
                'audio' => $audio,
                'queued' => false
            ]);
        }

        return $this->redirectToRoute('audios.index');
    }


    #[Route('/library', name: 'import', methods: ['get', 'post'])]
    public function uploadAudios(Request $request): Response
    {
        $form = ($this->createFormBuilder())
            ->add('file', AudioImportSourceType::class)
            ->getForm();

        $form->handleRequest($request);
        $errors = [];

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            $file = $file->move('/tmp', $file->getClientOriginalName());

            $importResult = $this->audioImporter->import($file->getRealPath());

            if ($importResult->ok()) {
                return $this->redirectToRoute('audios.index');
            }

            $errors = $importResult->errors;
        }

        return $this->render('audio/import_audios.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
}