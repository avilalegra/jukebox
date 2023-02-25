<?php

namespace App\Player\Application\Player\Status;

use App\Playlist\Domain\PlaylistReadModel;

readonly class PlayerStatus
{
    public function __construct(
        public AudioPlayingStatus $audioPlayStatus,
        public PlaylistReadModel  $queue
    )
    {
    }
}