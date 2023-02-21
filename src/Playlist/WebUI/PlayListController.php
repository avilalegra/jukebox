<?php

namespace App\Playlist\WebUI;

use App\Player\Application\Player\AudioPlayingStarted;
use App\Player\Application\Player\Player;
use App\Playlist\Application\PlayListBrowserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/playlists', name: 'playlists.')]
class PlayListController extends AbstractController  implements EventSubscriberInterface
{

    public function __construct(
        private HubInterface $mercureHub,
        private PlayListBrowserInterface $playListBrowser,
        private Player $player
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            AudioPlayingStarted::name() => 'onAudioPlayingStarted',
        ];
    }

    #[Route('/main', name: 'main')]
    public function mainPlaylist() : Response
    {
        $playlist = $this->playListBrowser->mainPlaylist();
        $status = $this->player->getStatus();

        return $this->render('playlist/main_playlist.html.twig',
            [
                'playlist' => $playlist,
                'nowPlaying' => $status->playingAudio?->audio
            ]
        );
    }

    public function onAudioPlayingStarted(AudioPlayingStarted $event)
    {
        $playlist = $this->playListBrowser->mainPlaylist();

        $status = $event->playerStatus;

        $this->mercureHub->publish(new Update('player-status',
            $this->renderView('playlist/main_playlist_audios_stream.html.twig',
                [
                    'playlist' => $playlist,
                    'nowPlaying' => $status->playingAudio?->audio,
                    'lastPlayed' => $status->lastPlayedAudio,
                ]
            )
        ));
    }
}