<?php

namespace App\Playlist\Application;

use App\Audio\Application\AudioEntityRepositoryInterface;

class PlaylistManagerFactory
{
    public function __construct(
        private PlaylistEntityRepositoryInterface $playlistRepository,
        private AudioEntityRepositoryInterface    $audioRepository
    )
    {
    }

    public function playlistEditor(string $playlistId): PlaylistManager
    {
        return new PlaylistManager($playlistId, $this->playlistRepository, $this->audioRepository);
    }

    public function mainPlaylistEditor(): PlaylistManager
    {
        return $this->playlistEditor('main');
    }
}