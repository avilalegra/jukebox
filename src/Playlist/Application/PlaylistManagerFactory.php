<?php

namespace App\Playlist\Application;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Playlist\Application\Interactor\PlaylistManagerFactoryInterface;


readonly class PlaylistManagerFactory implements PlaylistManagerFactoryInterface
{
    public function __construct(
        private PlaylistEntityRepositoryInterface $playlistRepository,
        private AudioEntityRepositoryInterface    $audioRepository
    )
    {
    }


    public function playlistManager(string $playlistId): PlaylistManager
    {
        $playlist = $this->playlistRepository->findPlaylist($playlistId);
        return new PlaylistManager($playlist, $this->playlistRepository, $this->audioRepository);
    }
}