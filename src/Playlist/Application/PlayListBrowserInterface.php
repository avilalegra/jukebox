<?php

namespace App\Playlist\Application;

use App\Playlist\Domain\PlaylistReadModel;

interface PlayListBrowserInterface
{
    public function playingPlaylist() : PlaylistReadModel;
}