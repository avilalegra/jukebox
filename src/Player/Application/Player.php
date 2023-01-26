<?php

declare(strict_types=1);

namespace App\Player\Application;

use App\Player\Application\Events\AudioPlayingStarted;
use App\Player\Application\Events\AudioPlayingStopped;
use App\Shared\Application\Album;
use App\Shared\Application\Audio;
use App\Shared\Application\EventDispatcherInterface;

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

    /**
     * @throws AudioDeviceException
     */
    public function playAlbum(Album $album): void
    {
        foreach ($album->audios as $audio) {
            $this->playAudio($audio);
        }
    }

    /**
     * @throws AudioDeviceException
     */
    public function playAudio(Audio $audio): void
    {
        $this->changeToPlayingStatus($audio);
        $this->eventDispatcher->fireEvent(new AudioPlayingStarted($this->getStatus()));

        $this->audioDevice->play($audio);

        $this->changeToStoppedStatus();
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($this->getStatus()));
    }

    public function changeToPlayingStatus(Audio $audio): void
    {
        $this->currentStatus = $this->playerStatusRepository->getCurrentStatus()->goPlaying($audio, $this->timeGenerator->epochTime());
        $this->playerStatusRepository->saveCurrentStatus($this->currentStatus);
    }

    public function getStatus(): PlayerStatus
    {
        if ($this->currentStatus === null) {
            $this->currentStatus = $this->playerStatusRepository->getCurrentStatus();
        }

        return $this->currentStatus;
    }

    public function changeToStoppedStatus(): void
    {
        $this->currentStatus = $this->getStatus()->goStopped();
        $this->playerStatusRepository->saveCurrentStatus($this->currentStatus);
    }

    public function stop(): void
    {
        $currentStatus = $this->playerStatusRepository->getCurrentStatus()->goStopped();
        $this->playerStatusRepository->saveCurrentStatus($currentStatus);
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($currentStatus));
    }
}