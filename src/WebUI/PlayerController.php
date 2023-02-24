<?php

declare(strict_types=1);

namespace App\WebUI;

use App\Player\Application\Player\AudioPlayingStarted;
use App\Player\Application\Player\AudioPlayingStopped;
use App\Player\Application\Player\PlayerManager;
use App\Playlist\Application\PlayListBrowserInterface;
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
        private PlayerManager $player,
        private PlayListBrowserInterface $playListBrowser
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


    #[Route('/', name: 'index')]
    public function playerIndex(Request $request) : Response
    {
//        dd($request->headers->get('referer'));
        $playlist = $this->playListBrowser->mainPlaylist();
        $status = $this->player->getStatus();

        return $this->render('player/player.html.twig',
            [
                'playlist' => $playlist,
                'nowPlaying' => $status->playingAudio?->audio,
                'lastPlayed' => $status->lastPlayedAudio,
            ]
        );
    }

    #[Route('/bar', name: 'bar')]
    public function playerBar(): Response
    {
        $status = $this->player->getStatus();

        return $this->render('player/player_bar.html.twig',
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
        return $this->redirectToRoute('player.index');
    }

    public function onAudioPlayingStarted(AudioPlayingStarted $event)
    {
        $playlist = $this->playListBrowser->mainPlaylist();

        $status = $event->playerStatus;

        $this->mercureHub->publish(new Update('player-board',
            $this->renderView('player/player_board_stream.html.twig',
                [
                    'playlist' => $playlist,
                    'nowPlaying' => $status->playingAudio?->audio,
                    'lastPlayed' => $status->lastPlayedAudio,
                ]
            )
        ));

        $this->mercureHub->publish(new Update('player-bar',
            $this->renderView('player/player_bar_stream.html.twig',
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

        $this->mercureHub->publish(new Update('player-bar',
            $this->renderView('player/player_bar_stream.html.twig',
                [
                    'nowPlaying' => null,
                    'lastPlayed' => $status->lastPlayedAudio,
                ]
            )
        ));
    }
}
