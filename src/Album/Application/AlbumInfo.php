<?php

namespace App\Album\Application;

readonly class AlbumInfo
{
    public function __construct(
        public string $name,
        public bool $hasCover
    )
    {
    }
}