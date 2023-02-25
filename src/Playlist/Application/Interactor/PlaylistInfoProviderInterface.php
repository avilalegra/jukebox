<?php

namespace App\Playlist\Application\Interactor;

use App\Playlist\Domain\PlaylistReadModel;

interface PlaylistInfoProviderInterface
{
    public function findPlaylist(string $name): PlaylistReadModel;
}