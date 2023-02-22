<?php

namespace App\Playlist\Application;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Shared\Domain\AudioReadModel;

class PlaylistManager
{
    public function __construct(
        private string                            $playlistId,
        private PlaylistEntityRepositoryInterface $playlistRepository,
        private AudioEntityRepositoryInterface    $audioRepository
    )
    {
    }

    /**
     * @param array<AudioReadModel> $audios
     */
    public function replaceAudios(array $audios): void
    {
        $playingPlaylist = $this->playlistRepository->findPlaylist($this->playlistId);

        $audios = array_map(
            fn(AudioReadModel $audio) => $this->audioRepository->find($audio->id),
            $audios
        );

        $playingPlaylist->replaceAudios($audios);
        $this->playlistRepository->update($playingPlaylist);
    }
}