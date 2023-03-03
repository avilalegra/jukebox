<?php

namespace App\Playlist\Application;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Playlist\Application\Interactor\PlaylistManagerFactoryInterface;
use App\Shared\Application\Exception\EntityNotFoundException;

class PlaylistManagerFactory implements PlaylistManagerFactoryInterface
{
    public function __construct(
        private PlaylistEntityRepositoryInterface $playlistRepository,
        private AudioEntityRepositoryInterface    $audioRepository
    )
    {
    }


    public function playlistEditor(string $playlistId): PlaylistManager
    {
        $playlist = $this->playlistRepository->findPlaylist($playlistId);
        return new PlaylistManager($playlist, $this->playlistRepository, $this->audioRepository);
    }
}