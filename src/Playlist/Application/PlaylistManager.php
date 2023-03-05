<?php

namespace App\Playlist\Application;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Domain\AudioReadModel;
use App\Playlist\Application\Interactor\PlaylistManagerInterface;
use App\Playlist\Domain\PlaylistEntity;

readonly class PlaylistManager implements PlaylistManagerInterface
{
    public function __construct(
        private PlaylistEntity                    $playlist,
        private PlaylistEntityRepositoryInterface $playlistRepository,
        private AudioEntityRepositoryInterface    $audioRepository
    )
    {
    }

    public function clear(): void
    {
        $this->playlist->clear();
    }

    public function add(AudioReadModel ...$audios): void
    {
        foreach ($audios as $audio) {
            $audioEntity = $this->audioRepository->find($audio->id);
            $this->playlist->add($audioEntity);
            $this->playlistRepository->update($this->playlist);
        }
    }

    public function remove(AudioReadModel $audio): void
    {
        $audioEntity = $this->audioRepository->find($audio->id);
        $this->playlist->remove($audioEntity);
        $this->playlistRepository->update($this->playlist);
    }
}