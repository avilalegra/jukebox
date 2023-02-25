<?php

namespace App\Player\Application\Player\Status;

use App\Playlist\Domain\PlaylistReadModel;
use App\Shared\Domain\AudioReadModel;

readonly class PlayerStatus
{
    public function __construct(
        public AudioPlayingStatus $audioPlayStatus,
        public PlaylistReadModel  $queue
    )
    {
    }

    public function isPlaying(AudioReadModel $audio): bool
    {
        return $this->audioPlayStatus->isPlaying($audio);
    }

    public function canAddToQueue(AudioReadModel $audio): bool
    {
        return !$this->queue->hasAudio($audio);
    }

    public function canRemoveFromQueue(AudioReadModel $audio): bool
    {
        $isQueued =  $this->queue->hasAudio($audio);
        $isNotPlaying = !$this->audioPlayStatus->isPlaying($audio);

        return $isQueued && $isNotPlaying;
    }
}