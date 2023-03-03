<?php

namespace App\Playlist\Application\Interactor;

use App\Shared\Application\Exception\EntityNotFoundException;

interface PlaylistManagerFactoryInterface
{
    /**
     * @throws EntityNotFoundException
     */
    public function playlistEditor(string $playlistId): PlaylistManagerInterface;
}