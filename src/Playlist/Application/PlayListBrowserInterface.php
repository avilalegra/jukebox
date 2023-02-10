<?php

namespace App\Playlist\Application;

interface PlayListBrowserInterface
{
    public function mainPlaylist() : Playlist;
}