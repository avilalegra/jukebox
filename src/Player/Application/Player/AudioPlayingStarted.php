<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Shared\Application\ApplicationEventInterface;

class AudioPlayingStarted implements ApplicationEventInterface
{
    public function __construct(
        public readonly AudioPlayingStatus $playerStatus
    ) {
    }

    public static function name(): string
    {
        return 'audio-playing-started';
    }
}
