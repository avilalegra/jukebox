<?php

namespace App\Album\Application;

class AlbumFactory
{
    public function __construct(
        private CoverStorageInterface $coverStorage
    )
    {
    }

    public function createAlbum(string $albumName): AlbumInfo
    {

    }
}