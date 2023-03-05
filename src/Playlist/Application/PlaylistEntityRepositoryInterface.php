<?php

namespace App\Playlist\Application;

use App\Playlist\Domain\PlaylistEntity;
use App\Playlist\Domain\PlaylistReadModel;
use App\Shared\Application\Exception\EntityNotFoundException;

interface PlaylistEntityRepositoryInterface
{
    public function update(PlaylistEntity $playlist) : void;

    public function findPlaylist(string $playlistId) : PlaylistEntity;
}