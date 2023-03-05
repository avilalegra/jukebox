<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Shared\Application\ApplicationEventInterface;

readonly class AudioPlayingStopped implements ApplicationEventInterface
{
    public function __construct(
        public AudioPlayingStatus $playerStatus
    ) {
    }

    public static function name(): string
    {
        return 'audio-playing-stopped';
    }
}
