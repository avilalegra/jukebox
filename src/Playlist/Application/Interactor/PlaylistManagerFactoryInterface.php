<?php

namespace App\Playlist\Application\Interactor;

interface PlaylistManagerFactoryInterface
{
    public function playlistEditor(string $playlistId): PlaylistManagerInterface;
}