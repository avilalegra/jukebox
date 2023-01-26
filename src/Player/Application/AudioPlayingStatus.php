<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Shared\Application\Audio;


class AudioPlayingStatus
{
    public function __construct(
        public readonly Audio $audio,
        public readonly int $startedAt
    )
    {
    }
}