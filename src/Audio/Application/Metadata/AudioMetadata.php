<?php

namespace App\Audio\Application\Metadata;

use Spatie\Cloneable\Cloneable;

readonly class AudioMetadata
{
    use Cloneable;

    public function __construct(
        public ?string $title,
        public ?string $artist,
        public ?string $album,
        public string $year,
        public ?int $track,
        public ?string $genre,
        public ?string $lyrics,
        public ?int $duration,
    )
    {
    }
}