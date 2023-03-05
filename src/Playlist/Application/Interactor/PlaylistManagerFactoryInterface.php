<?php

namespace App\Playlist\Application\Interactor;

use App\Shared\Application\Exception\EntityNotFoundException;

interface PlaylistManagerFactoryInterface
{
    public function playlistManager(string $playlistId): PlaylistManagerInterface;
}