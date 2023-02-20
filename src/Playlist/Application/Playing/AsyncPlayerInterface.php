<?php

declare(strict_types=1);

namespace App\Playlist\Application\Playing;

use App\Player\Application\Player\Status\PlayerStatus;


interface AsyncPlayerInterface
{
    public function playAudioAsync(string $audioId): void;

    public function playQueueAsync()  : void;

    public function stop(): void;

    public function getStatus(): PlayerStatus;
}
