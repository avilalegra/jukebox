<?php

namespace App\Player\Application\Player;

use App\Album\Application\AlbumBrowserInterface;
use App\Player\Application\Player\Status\PlayerStatus;
use App\Playlist\Application\PlaylistManagerFactory;

class PlayerManager
{
    public function __construct(
        private AsyncPlayerInterface   $asyncPlayer,
        private AlbumBrowserInterface  $albumBrowser,
        private PlaylistManagerFactory $playlistManagerFactory
    )
    {
    }

    public function playAudio(string $audioId): void
    {
        $this->asyncPlayer->playAudioAsync($audioId);
    }

    public function playAlbum(string $albumName): void
    {
        $audios = $this->albumBrowser->findAlbumAudios($albumName);
        $mainPlaylistEditor = $this->playlistManagerFactory->mainPlaylistEditor();
        $mainPlaylistEditor->replaceAudios($audios);
        $this->asyncPlayer->playMainPlaylistAsync();
    }

    public function stop(): void
    {
        $this->asyncPlayer->stop();
    }

    public function getStatus(): PlayerStatus
    {
        return $this->asyncPlayer->getStatus();
    }
}