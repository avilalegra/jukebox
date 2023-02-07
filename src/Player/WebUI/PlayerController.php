<?php

declare(strict_types=1);

namespace App\Player\WebUI;

use App\Player\Application\AsyncPlayerInterface;
use App\Player\Application\Events\AudioPlayingStarted;
use App\Player\Application\Events\AudioPlayingStopped;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Turbo\TurboBundle;

#[Route('/player', name: 'player.')]
class PlayerController extends AbstractController implements EventSubscriberInterface
{
    public function __construct(
        private HubInterface $mercureHub,
        private AsyncPlayerInterface $player
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            AudioPlayingStarted::name() => 'onAudioPlayingStarted',
            AudioPlayingStopped::name() => 'onAudioPlayingStopped',
        ];
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $status = $this->player->getStatus();

        return $this->render('player/player.html.twig',
            [
                'audios' => $status->playingAlbum?->audios ?? [],
                'nowPlaying' => $status->playingAudio,
                'lastPlayed' => $status->lastPlayedAudio,
            ]
        );
    }

    #[Route('/controls', name: 'controls')]
    public function playerControls(): Response
    {
        $status = $this->player->getStatus();

        return $this->render('player/player_controls.html.twig',
            [
                'nowPlaying' => $status->playingAudio,
                'lastPlayed' => $status->lastPlayedAudio,
            ]
        );
    }

    #[Route('/audios/playing', name: 'stop', methods: ['post'])]
    public function stop(Request $request): Response
    {
        $this->player->stop();

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return new Response();
        }

        return $this->redirectToRoute('player.index');
    }

    #[Route('/audios/{id}', name: 'play', methods: ['post'])]
    public function playAudio(string $id, Request $request): Response
    {
        $this->player->playAudioAsync($id);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return new Response();
        }

        return $this->redirectToRoute('player.index');
    }

    #[Route('/album/{id}', name: 'playAlbum')]
    public function playAlbum(string $id): Response
    {
        $this->player->playAlbumAsync($id);

        return $this->redirectToRoute('player.index');
    }

    public function onAudioPlayingStarted(AudioPlayingStarted $event)
    {
        $status = $event->playerStatus;

        $this->mercureHub->publish(new Update('player-status',
            $this->renderView('player/player_update.html.twig',
                [
                    'audios' => $status->playingAlbum->audios,
                    'nowPlaying' => $status->playingAudio,
                    'lastPlayed' => $status->lastPlayedAudio,
                ]
            )
        ));
    }

    public function onAudioPlayingStopped(AudioPlayingStopped $event)
    {
        $status = $this->player->getStatus();

        $this->mercureHub->publish(new Update('player-status',
            $this->renderView('player/player_controls_update.html.twig',
                [
                    'nowPlaying' => null,
                    'lastPlayed' => $status->lastPlayedAudio,
                ]
            )
        ));
    }
}
