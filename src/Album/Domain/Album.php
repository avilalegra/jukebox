<?php

declare(strict_types=1);

namespace App\Album\Domain;

use App\Audio\Domain\AudioEntity;

readonly class Album
{
    /**
     * @param array<AudioEntity> $audios
     */
    public function __construct(
        public string $name,
        public array $audios
    )
    {
    }
}
