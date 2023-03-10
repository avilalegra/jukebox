<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Album\Domain\Album;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerInterface;
use App\Player\Application\Interactor\PlayerQueueManagerInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\Status\PlayingStatusManager;


readonly class SyncPlayer implements PlayerInterface
{

    public function __construct(
        private PlayingStatusManager              $playingStatusManager,
        private AudioDeviceInterface              $audioDevice,
        private PlayerStatusInfoProviderInterface $playerStatusInfoProvider,
        private PlayerQueueManagerInterface       $queueManager
    )
    {
    }

    public function playAudio(AudioReadModel $audio): void
    {
        $this->playingStatusManager->changeToPlayingStatus($audio);

        $this->audioDevice->play($audio);

        $this->playingStatusManager->changeToPlayingStatus($audio);
    }

    public function playQueue(): void
    {
        $queuedAudios = $this->playerStatusInfoProvider->playerStatus()->queuedAudios;
        foreach ($queuedAudios as $audio) {
            $this->playAudio($audio);
        }
    }

    public function playAlbum(Album $album): void
    {
        $this->queueManager->clearQueue();
        $this->queueManager->addToQueue(...$album->audios);
        $this->playQueue();
    }

    public function stop(): void
    {
        $this->playingStatusManager->changeToStoppedStatus();
    }
}
