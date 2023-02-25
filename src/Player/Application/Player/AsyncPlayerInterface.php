<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Player\Application\Player\Status\AudioPlayingStatus;


interface AsyncPlayerInterface
{
    public function playAudioAsync(string $audioId): void;

    public function playQueueAsync()  : void;

    public function stop(): void;
}
