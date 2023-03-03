<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Device\AudioDevicePlayingException;
use App\Player\Application\Device\AudioDeviceInterface;
use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;
use App\Shared\Application\EventDispatcherInterface;

class Player
{
    private ?AudioPlayingStatus $currentStatus;

    public function __construct(
        private AudioDeviceInterface                  $audioDevice,
        private EventDispatcherInterface              $eventDispatcher,
        private AudioPlayingStatusRepositoryInterface $playingStatusRepository,
        private TimeGeneratorInterface                $timeGenerator
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
     * @throws AudioDevicePlayingException
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
        $this->currentStatus = $this->playingStatusRepository->status()->playingTransition($audio, $this->timeGenerator->epochTime());
        $this->playingStatusRepository->save($this->currentStatus);
    }

    public function getStatus(): AudioPlayingStatus
    {
        if (null === $this->currentStatus) {
            $this->currentStatus = $this->playingStatusRepository->status();
        }

        return $this->currentStatus;
    }

    public function changeToStoppedStatus(): void
    {
        $this->currentStatus = $this->getStatus()->stopTransition();
        $this->playingStatusRepository->save($this->currentStatus);
    }

    public function stop(): void
    {
        $currentStatus = $this->playingStatusRepository->status()->stopTransition();
        $this->playingStatusRepository->save($currentStatus);
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($currentStatus));
    }
}
