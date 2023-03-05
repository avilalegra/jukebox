<?php

namespace App\Player\Infrastructure;

use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\PlayerQueueManager;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;
use App\Player\Application\Player\Status\PlayerStatus;
use App\Playlist\Application\Interactor\PlaylistInfoProviderInterface;


readonly class PlayerStatusInfoProvider implements PlayerStatusInfoProviderInterface
{
    public function __construct(
        private PlaylistInfoProviderInterface         $playlistInfoProvider,
        private AudioPlayingStatusRepositoryInterface $playingStatusRepository
    )
    {
    }

    public function status(): PlayerStatus
    {
        return new PlayerStatus(
            audioPlayingStatus: $this->playingStatusRepository->status(),
            queuedAudios: $this->playlistInfoProvider->findPlaylist(PlayerQueueManager::PLAYER_QUEUE_PLAYLIST_ID)->audios
        );
    }
}