<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;
use App\Shared\Application\EventDispatcherInterface;


class Player
{
    private ?AudioPlayingStatus $currentAudioPlayingStatus;

    public function __construct(
        private readonly AudioDeviceInterface                  $audioDevice,
        private readonly EventDispatcherInterface              $eventDispatcher,
        private readonly AudioPlayingStatusRepositoryInterface $audioPlayingStatusRepository,
        private readonly TimeGeneratorInterface                $timeGenerator
    )
    {
        $this->currentAudioPlayingStatus = null;
    }

    public function playAll(AudioReadModel ...$audios): void
    {
        foreach ($audios as $audio) {
            $this->playAudio($audio);
        }
    }


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
        $this->currentAudioPlayingStatus = $this->audioPlayingStatusRepository
            ->status()->playingTransition($audio, $this->timeGenerator->epochTime());
        $this->audioPlayingStatusRepository->save($this->currentAudioPlayingStatus);
    }

    public function getStatus(): AudioPlayingStatus
    {
        if (null === $this->currentAudioPlayingStatus) {
            $this->currentAudioPlayingStatus = $this->audioPlayingStatusRepository->status();
        }

        return $this->currentAudioPlayingStatus;
    }

    public function changeToStoppedStatus(): void
    {
        $this->currentAudioPlayingStatus = $this->getStatus()->stopTransition();
        $this->audioPlayingStatusRepository->save($this->currentAudioPlayingStatus);
    }

    public function stop(): void
    {
        $currentStatus = $this->audioPlayingStatusRepository->status()->stopTransition();
        $this->audioPlayingStatusRepository->save($currentStatus);
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($currentStatus));
    }
}
