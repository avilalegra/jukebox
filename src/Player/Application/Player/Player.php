<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Player\Application\Device\AudioDeviceException;
use App\Player\Application\Device\AudioDeviceInterface;
use App\Player\Application\Player\Status\PlayerStatus;
use App\Player\Application\Player\Status\PlayerStatusRepositoryInterface;
use App\Shared\Application\EventDispatcherInterface;
use App\Shared\Domain\AudioReadModel;

class Player
{
    private ?PlayerStatus $currentStatus;

    public function __construct(
        private AudioDeviceInterface            $audioDevice,
        private EventDispatcherInterface        $eventDispatcher,
        private PlayerStatusRepositoryInterface $playerStatusRepository,
        private TimeGeneratorInterface          $timeGenerator
    )
    {
        $this->currentStatus = null;
    }

    public function playAll(AudioReadModel ...$audios): void
    {
        foreach ($audios as $audio) {
            $this->playAudio($audio);
        }
    }

    /**
     * @throws AudioDeviceException
     */
    public function playAudio(AudioReadModel $audio): void
    {
        $this->changeToPlayingStatus($audio);
        $this->eventDispatcher->fireEvent(new AudioPlayingStarted($this->getStatus()));

        $this->audioDevice->play($audio);

        $this->changeToStoppedStatus();
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($this->getStatus()));
    }

    public function changeToPlayingStatus(AudioReadModel $audio): void
    {
        $this->currentStatus = $this->playerStatusRepository->getCurrentStatus()->playingTransition($audio, $this->timeGenerator->epochTime());
        $this->playerStatusRepository->saveCurrentStatus($this->currentStatus);
    }

    public function getStatus(): PlayerStatus
    {
        if (null === $this->currentStatus) {
            $this->currentStatus = $this->playerStatusRepository->getCurrentStatus();
        }

        return $this->currentStatus;
    }

    public function changeToStoppedStatus(): void
    {
        $this->currentStatus = $this->getStatus()->stopTransition();
        $this->playerStatusRepository->saveCurrentStatus($this->currentStatus);
    }

    public function stop(): void
    {
        $currentStatus = $this->playerStatusRepository->getCurrentStatus()->stopTransition();
        $this->playerStatusRepository->saveCurrentStatus($currentStatus);
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($currentStatus));
    }
}
