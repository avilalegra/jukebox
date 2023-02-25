<?php

namespace App\Player\Application\Interactor;

use App\Shared\Domain\AudioReadModel;

interface PlayerQueueInterface
{
    public function clear(): void;

    public function add(AudioReadModel ...$audios): void;

    public function remove(AudioReadModel $audio): void;
}