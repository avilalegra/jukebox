<?php

namespace App\Player\Application\Player\Status;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerQueueManagerInterface;
use App\Playlist\Domain\PlaylistReadModel;
use Doctrine\Common\Collections\Collection;

readonly class PlayerStatus
{
    /**
     * @param AudioPlayingStatus $audioPlayingStatus
     * @param array<AudioReadModel> $queuedAudios
     */
    public function __construct(
        public AudioPlayingStatus $audioPlayingStatus,
        public array              $queuedAudios
    )
    {
    }

    public function isPlaying(AudioReadModel $audio): bool
    {
        return $this->audioPlayingStatus->isPlaying($audio);
    }

    public function hasQueuedAudio(AudioReadModel $audio): bool
    {
        return in_array($audio, $this->queuedAudios);
    }
}