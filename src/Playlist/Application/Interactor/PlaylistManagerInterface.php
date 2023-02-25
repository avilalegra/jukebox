<?php

namespace App\Playlist\Application\Interactor;

use App\Shared\Domain\AudioReadModel;

interface PlaylistManagerInterface
{
    public function clear(): void;

    public function add(AudioReadModel ...$audios): void;

    public function remove(AudioReadModel $audio): void;
}