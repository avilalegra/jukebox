<?php

namespace App\Playlist\Application;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Playlist\Domain\PlaylistEntity;
use App\Shared\Domain\AudioReadModel;

class PlaylistManager
{
    public function __construct(
        private PlaylistEntity                    $playlist,
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
        $audios = array_map(
            fn(AudioReadModel $audio) => $this->audioRepository->find($audio->id),
            $audios
        );

        $this->playlist->replaceAudios($audios);
        $this->playlistRepository->update($this->playlist);
    }

    public function addToPlaylist(AudioReadModel $audio): void
    {
        $audio = $this->audioRepository->find($audio->id);
        $this->playlist->addAudio($audio);
        $this->playlistRepository->update($this->playlist);
    }

    public function removeFromPlaylist(AudioReadModel $audio): void
    {
        $audio = $this->audioRepository->find($audio->id);
        $this->playlist->removeAudio($audio);
        $this->playlistRepository->update($this->playlist);
    }
}