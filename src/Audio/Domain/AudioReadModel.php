<?php

declare(strict_types=1);

namespace App\Audio\Domain;

readonly class AudioReadModel
{
    public function __construct(
        public string  $id,
        public ?string $title,
        public ?string $artist,
        public ?string $album,
        public ?string $year,
        public ?int    $track,
        public ?string $genre,
        public ?string $lyrics,
        public ?int    $duration,
        public string  $extension
    )
    {
    }

    public function equals(?AudioReadModel $audio): bool
    {
        return $audio !== null && ($this->id === $audio->id);
    }
}