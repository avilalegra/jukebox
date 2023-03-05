<?php

namespace App\Player\Application\Player;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerQueueManagerInterface;
use App\Playlist\Application\PlaylistManager;
use App\Playlist\Application\PlaylistManagerFactory;

class PlayerQueueManager implements PlayerQueueManagerInterface
{
    const PLAYER_QUEUE_PLAYLIST_ID = 'c8420338-16d0-4584-9b06-9b3697e084d9';

    private PlaylistManager $mainPlaylistManager;

    public function __construct(
        PlaylistManagerFactory $managerFactory
    )
    {
        $this->mainPlaylistManager = $managerFactory->playlistManager(self::PLAYER_QUEUE_PLAYLIST_ID);
    }

    public function clear(): void
    {
        $this->mainPlaylistManager->clear();
    }

    public function add(AudioReadModel ...$audios): void
    {
        $this->mainPlaylistManager->add(...$audios);
    }

    public function remove(AudioReadModel $audio): void
    {
        $this->mainPlaylistManager->remove($audio);
    }
}