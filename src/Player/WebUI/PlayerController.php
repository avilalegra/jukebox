<?php

declare(strict_types=1);

namespace App\Player\WebUI;

use App\Player\Application\Player\AsyncPlayerInterface;
use App\Player\Application\Player\AudioPlayingStarted;
use App\Player\Application\Player\AudioPlayingStopped;
use App\Player\Application\Player\PlayerManager;
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
        private HubInterface         $mercureHub,
        private PlayerManager $player
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            AudioPlayingStarted::name() => 'onAudioPlayingStarted',
            AudioPlayingStopped::name() => 'onAudioPlayingStopped',
        ];
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

    #[Route('/audios/{id}', name: 'play.audio', methods: ['post'])]
    public function playAudio(string $id, Request $request): Response
    {
        $this->player->playAudio($id);

        if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat()) {
            $request->setRequestFormat(TurboBundle::STREAM_FORMAT);

            return new Response();
        }

        return $this->redirectToRoute('player.index');
    }

    #[Route('/album/{name}', name: 'play.album', methods: ['POST'])]
    public function playAlbum(string $name): Response
    {
        $this->player->playAlbum($name);
        return $this->redirectToRoute('playlists.main');
    }

    public function onAudioPlayingStarted(AudioPlayingStarted $event)
    {
        $status = $event->playerStatus;

        $this->mercureHub->publish(new Update('player-status',
            $this->renderView('player/player_controls_stream.html.twig',
                [
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
            $this->renderView('player/player_controls_stream.html.twig',
                [
                    'nowPlaying' => null,
                    'lastPlayed' => $status->lastPlayedAudio,
                ]
            )
        ));
    }
}
