<?php

namespace App\WebUI;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Player\Application\Interactor\PlayerQueueInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/audios', name: 'audios.')]
class AudiosController extends AbstractController
{
    public function __construct(
        private AudioInfoProviderInterface        $audioBrowser,
        private PlayerStatusInfoProviderInterface $statusInfoProvider,
        private PlayerQueueInterface              $playerQueue,
    )
    {
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $status = $this->statusInfoProvider->status();
        $audios = $this->audioBrowser->paginateAudios();
        $queue = $status->queue;
        $nowPlaying = $status->audioPlayStatus->playingAudio?->audio;

        return $this->render(
            'audio/audio_browser.html.twig',
            [
                'audios' => $audios,
                'queue' => $queue,
                'nowPlaying' => $nowPlaying
            ]
        );
    }

    #[Route('/{id}/queue', name: 'addToPlayingQueue', methods: ['post'])]
    public function addToPlayingQueue(string $id, Request $request): Response
    {
        $audio = $this->audioBrowser->findAudio($id);
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
        $audio = $this->audioBrowser->findAudio($id);
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
}