<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\AudioReadModel;

class AudioPlayingStatus
{
    public function __construct(
        public readonly AudioReadModel $audio,
        public readonly int            $startedAt
    ) {
    }
}
