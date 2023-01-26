<?php

declare(strict_types=1);

namespace App\Player\Application;

interface AsyncPlayerInterface
{
    public function playAudioAsync(string $audioId): void;

    public function playAlbumAsync(string $albumId): void;

    public function stop(): void;

    public function getStatus(): PlayerStatus;
}