<?php

namespace App\Player\Application\Player\Status;

use App\Audio\Domain\AudioReadModel;
use App\Playlist\Domain\PlaylistReadModel;

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