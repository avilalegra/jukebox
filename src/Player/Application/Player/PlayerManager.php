<?php

namespace App\Player\Application\Player;

use App\Album\Application\Interactor\AlbumInfoProviderInterface;
use App\Player\Application\Interactor\JukeboxPlayerInterface;
use App\Player\Application\Interactor\PlayerQueueInterface;


class PlayerManager implements JukeboxPlayerInterface
{
    public function __construct(
        private AsyncPlayerInterface       $asyncPlayer,
        private AlbumInfoProviderInterface $albumBrowser,
        private PlayerQueueInterface       $playerQueue
    )
    {
    }

    public function playAudio(string $audioId): void
    {
        $this->asyncPlayer->playAudioAsync($audioId);
    }

    public function playAlbum(string $albumName): void
    {
        $audios = $this->albumBrowser->findAlbumAudios($albumName);
        $this->playerQueue->clear();
        $this->playerQueue->add(...$audios);
        $this->asyncPlayer->playQueueAsync();
    }

    public function stop(): void
    {
        $this->asyncPlayer->stop();
    }
}