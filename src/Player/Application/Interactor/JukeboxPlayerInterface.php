<?php

namespace App\Player\Application\Interactor;


interface JukeboxPlayerInterface
{
    public function playAudio(string $audioId): void;

    public function playAlbum(string $albumName): void;

    public function stop(): void;
}