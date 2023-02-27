<?php

declare(strict_types=1);

namespace App\Player\Application\Player\Status;

use App\Audio\Domain\AudioReadModel;

readonly class CurrentPlayingAudioStatus
{
    public function __construct(
        public AudioReadModel $audio,
        public int            $startedAt
    ) {
    }
}
