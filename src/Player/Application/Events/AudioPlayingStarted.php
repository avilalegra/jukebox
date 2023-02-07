<?php

declare(strict_types=1);

namespace App\Player\Application\Events;

use App\Player\Application\PlayerStatus;
use App\Shared\Application\ApplicationEventInterface;

class AudioPlayingStarted implements ApplicationEventInterface
{
    public function __construct(
        public readonly PlayerStatus $playerStatus
    ) {
    }

    public static function name(): string
    {
        return 'audio-playing-started';
    }
}
