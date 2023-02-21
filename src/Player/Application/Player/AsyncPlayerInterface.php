<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Player\Application\Player\Status\PlayerStatus;


interface AsyncPlayerInterface
{
    public function playAudioAsync(string $audioId): void;

    public function playMainPlaylistAsync()  : void;

    public function stop(): void;

    public function getStatus(): PlayerStatus;
}
