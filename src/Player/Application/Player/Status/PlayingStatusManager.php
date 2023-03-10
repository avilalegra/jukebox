<?php

namespace App\Player\Application\Player\Status;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Player\AudioPlayingStarted;
use App\Player\Application\Player\AudioPlayingStopped;
use App\Player\Application\Player\TimeGeneratorInterface;
use App\Shared\Application\EventDispatcherInterface;

readonly class PlayingStatusManager
{
    public function __construct(
        private AudioPlayingStatusRepositoryInterface $playingStatusRepository,
        private EventDispatcherInterface              $eventDispatcher,
        private TimeGeneratorInterface                $timeGenerator,
    )
    {
    }

    public function changeToPlayingStatus(AudioReadModel $audio): void
    {
        $newStatus = new AudioPlayingStatus(
            new CurrentPlayingAudioStatus($audio, $this->timeGenerator->epochTime()),
            $this->playingStatus()->currentPlayingAudio?->audio
        );

        $this->playingStatusRepository->save($newStatus);
        $this->eventDispatcher->fireEvent(new AudioPlayingStarted($newStatus));
    }

    public function changeToStoppedStatus(): void
    {
        $newStatus = new AudioPlayingStatus(null, $this->playingStatus()->currentPlayingAudio?->audio);
        $this->playingStatusRepository->save($newStatus);

        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($newStatus));
    }

    public function playingStatus(): AudioPlayingStatus
    {
        return $this->playingStatusRepository->status();
    }
}