<?php

namespace App\Player\Application\Interactor;


use App\Album\Domain\Album;
use App\Audio\Domain\AudioReadModel;

interface PlayerInterface
{
    public function playAudio(AudioReadModel $audio): void;

    public function playAlbum(Album $album): void;

    public function playQueue() : void;

    public function stop(): void;
}