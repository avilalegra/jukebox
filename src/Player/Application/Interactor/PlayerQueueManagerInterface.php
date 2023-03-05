<?php

namespace App\Player\Application\Interactor;

use App\Audio\Domain\AudioReadModel;

interface PlayerQueueManagerInterface
{
    public function clear(): void;

    public function add(AudioReadModel ...$audios): void;

    public function remove(AudioReadModel $audio): void;
}