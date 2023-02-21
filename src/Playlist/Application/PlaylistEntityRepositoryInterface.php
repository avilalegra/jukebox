<?php

namespace App\Playlist\Application;

use App\Playlist\Domain\PlaylistEntity;

interface PlaylistEntityRepositoryInterface
{
    public function update(PlaylistEntity $playlist) : void;

    public function findPlaylist(string $playlistId) : PlaylistEntity;
}