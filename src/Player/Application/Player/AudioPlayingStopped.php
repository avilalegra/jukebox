<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Player\Application\Player\Status\PlayerStatus;
use App\Shared\Application\ApplicationEventInterface;

class AudioPlayingStopped implements ApplicationEventInterface
{
    public function __construct(
        public readonly PlayerStatus $playerStatus
    ) {
    }

    public static function name(): string
    {
        return 'audio-playing-stopped';
    }
}