<?php

namespace App\Library\Application;

readonly class AudioMetadata
{
    public function __construct(
        public ?string $title,
        public ?string $artist,
        public ?string $album,
        public ?int $year,
        public ?int $track,
        public ?string $genre,
        public ?string $lyrics,
        public ?int $duration
    )
    {
    }
}