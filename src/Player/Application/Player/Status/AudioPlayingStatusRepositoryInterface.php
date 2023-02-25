<?php

declare(strict_types=1);

namespace App\Player\Application\Player\Status;

interface AudioPlayingStatusRepositoryInterface
{
    public function save(AudioPlayingStatus $playerStatus): void;

    public function status(): AudioPlayingStatus;
}
