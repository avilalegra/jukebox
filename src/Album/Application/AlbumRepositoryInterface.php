<?php

namespace App\Album\Application;

use App\Album\Domain\Album;

interface AlbumRepositoryInterface
{
    public function findAlbum(string $name) : Album;
}