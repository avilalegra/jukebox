<?php

declare(strict_types=1);

namespace App\Player\Application\Player;

use App\Album\Domain\Album;
use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerInterface;
use App\Player\Application\Interactor\PlayerQueueManagerInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\Status\AudioPlayingStatus;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;
use App\Shared\Application\EventDispatcherInterface;


class SyncPlayer implements PlayerInterface
{
    private ?AudioPlayingStatus $currentAudioPlayingStatus;

    public function __construct(
        private readonly AudioDeviceInterface                  $audioDevice,
        private readonly EventDispatcherInterface              $eventDispatcher,
        private readonly AudioPlayingStatusRepositoryInterface $audioPlayingStatusRepository,
        private readonly TimeGeneratorInterface                $timeGenerator,
        private readonly PlayerStatusInfoProviderInterface     $playerStatusInfoProvider,
        private readonly PlayerQueueManagerInterface           $queueManager
    )
    {
        $this->currentAudioPlayingStatus = null;
    }

    public function playAudio(AudioReadModel $audio): void
    {
        $this->changeToPlayingStatus($audio);
        $this->eventDispatcher->fireEvent(new AudioPlayingStarted($this->playingStatus()));

        $this->audioDevice->play($audio);

        $this->changeToStoppedStatus();
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($this->playingStatus()));
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
        $currentStatus = $this->audioPlayingStatusRepository->status()->stopTransition();
        $this->audioPlayingStatusRepository->save($currentStatus);
        $this->eventDispatcher->fireEvent(new AudioPlayingStopped($currentStatus));
    }

    public function changeToPlayingStatus(AudioReadModel $audio): void
    {
        $this->currentAudioPlayingStatus = $this->audioPlayingStatusRepository
            ->status()->playingTransition($audio, $this->timeGenerator->epochTime());
        $this->audioPlayingStatusRepository->save($this->currentAudioPlayingStatus);
    }

    public function playingStatus(): AudioPlayingStatus
    {
        if (null === $this->currentAudioPlayingStatus) {
            $this->currentAudioPlayingStatus = $this->audioPlayingStatusRepository->status();
        }

        return $this->currentAudioPlayingStatus;
    }

    public function changeToStoppedStatus(): void
    {
        $this->currentAudioPlayingStatus = $this->playingStatus()->stopTransition();
        $this->audioPlayingStatusRepository->save($this->currentAudioPlayingStatus);
    }
}
