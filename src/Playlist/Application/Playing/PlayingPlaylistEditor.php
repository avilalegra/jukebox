<?php

namespace App\Playlist\Application\Playing;

use App\Library\Domain\AudioEntity;
use App\Playlist\Application\PlaylistEntityRepositoryInterface;
use App\Shared\Domain\AudioReadModel;

class PlayingPlaylistEditor
{
    public function __construct(
        private PlaylistEntityRepositoryInterface $playlistRepository
    )
    {
    }

    /**
     * @param array<AudioEntity> $audios
     */
    public function replaceAudios(array $audios): void
    {
        $playingPlaylist = $this->playlistRepository->findPlayingPlaylist();
        $playingPlaylist->replaceAudios($audios);
        $this->playlistRepository->update($playingPlaylist);
    }
}