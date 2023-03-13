<?php

namespace App\Player\Application\Player;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerQueueManagerInterface;
use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Playlist\Application\PlaylistManager;
use App\Playlist\Application\PlaylistManagerFactory;

class PlayerQueueManager implements PlayerQueueManagerInterface
{
    const PLAYER_QUEUE_PLAYLIST_ID = 'ee6be059-c8d8-42aa-aad1-76c45d7cb30f';

    private PlaylistManager $mainPlaylistManager;

    public function __construct(
        PlaylistManagerFactory                    $managerFactory,
        private readonly PlayerStatusInfoProviderInterface $statusInfoProvider
    )
    {
        $this->mainPlaylistManager = $managerFactory->playlistManager(self::PLAYER_QUEUE_PLAYLIST_ID);
    }

    public function clearQueue(): void
    {
        $this->mainPlaylistManager->clear();
        $currentPlayingStatus = $this->statusInfoProvider->playerStatus()->audioPlayingStatus->currentPlayingAudio;

        if ($currentPlayingStatus !== null) {
            $this->mainPlaylistManager->add($currentPlayingStatus->audio);
        }
    }

    public function addToQueue(AudioReadModel ...$audios): void
    {
        $this->mainPlaylistManager->add(...$audios);
    }

    public function removeFromQueue(AudioReadModel $audio): void
    {
        $this->mainPlaylistManager->remove($audio);
    }
}