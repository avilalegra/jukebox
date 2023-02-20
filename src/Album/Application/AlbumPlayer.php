<?php

namespace App\Album\Application;

use App\Playlist\Application\Playing\AsyncPlayerInterface;
use App\Playlist\Application\Playing\PlayingPlaylistEditor;

class AlbumPlayer
{
    public function __construct(
        private AlbumRepositoryInterface $albumRepository,
        private PlayingPlaylistEditor    $playingPlaylistEditor,
        private AsyncPlayerInterface     $asyncPlayer
    )
    {
    }

    public function playAlbum(string $name): void
    {
        $album = $this->albumRepository->findAlbum($name);
        $this->playingPlaylistEditor->replaceAudios($album->audios);
        $this->asyncPlayer->playQueueAsync();
    }
}