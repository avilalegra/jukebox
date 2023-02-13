<?php

namespace App\Playlist\Domain;


use App\Shared\Domain\AudioReadModel;

readonly class PlaylistReadModel
{
    /**
     * @param array<AudioReadModel> $audios
     */
    public function __construct(
        public string $id,
        public string $name,
        public array  $audios
    )
    {
    }
}