<?php

namespace App\Player\Application\Interactor;

use App\Audio\Domain\AudioReadModel;

interface PlayerQueueManagerInterface
{
    public function clearQueue(): void;

    public function addToQueue(AudioReadModel ...$audios): void;

    public function removeFromQueue(AudioReadModel $audio): void;
}