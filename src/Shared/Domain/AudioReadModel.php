<?php

declare(strict_types=1);

namespace App\Shared\Domain;

readonly class AudioReadModel
{
    public function __construct(
        public string $id,
        public ?string $title,
        public ?string $artist,
        public ?string $album,
        public ?int $year,
        public ?int $track,
        public ?string $genre,
        public ?string $lyrics,
        public ?int $duration,
        public string $extension
    )
    {
    }
}