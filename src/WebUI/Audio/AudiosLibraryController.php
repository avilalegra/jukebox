<?php

namespace App\WebUI\Audio;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Audio\Application\Interactor\AudioLibraryManagerInterface;
use App\Player\Application\Interactor\PlayerQueueManagerInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Shared\WebUI\PaginationParamsTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/library/audios', name: 'audios.')]
class AudiosLibraryController extends AbstractController
{
    use PaginationParamsTrait;

    public function __construct(
        private readonly AudioInfoProviderInterface        $audioInfoProvider,
        private readonly PlayerStatusInfoProviderInterface $statusInfoProvider,
        private readonly PlayerQueueManagerInterface       $playerQueue,
        private readonly AudioLibraryManagerInterface      $audioLibraryManager
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {

        $status = $this->statusInfoProvider->playerStatus();
        $paginationResults = $this->audioInfoProvider->paginateAudios($this->parsePaginationParams($request));
        $nowPlaying = $status->audioPlayingStatus->currentPlayingAudio?->audio;

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
        $this->playerQueue->addToQueue($audio);

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
        $this->playerQueue->removeFromQueue($audio);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return $this->render('audio/playlist_actions_stream.html.twig', [
                'audio' => $audio,
                'queued' => false
            ]);
        }

        return $this->redirectToRoute('audios.index');
    }
}