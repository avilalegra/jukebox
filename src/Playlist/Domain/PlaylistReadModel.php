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

    public function hasAudio(AudioReadModel $audio): bool
    {
        foreach ($this->audios as $a) {
            if ($a->equals($audio)) {
                return true;
            }
        }
        return false;
    }
}