<?php

namespace App\Player\Application\Player;

use App\Audio\Domain\AudioReadModel;
use App\Player\Application\Interactor\PlayerQueueInterface;
use App\Playlist\Application\PlaylistManager;
use App\Playlist\Application\PlaylistManagerFactory;

class PlayerQueue implements PlayerQueueInterface
{
    const MAIN_PLAYLIST_ID = 'c8420338-16d0-4584-9b06-9b3697e084d9';
    private PlaylistManager $queueManager;

    public function __construct(
        PlaylistManagerFactory $managerFactory
    )
    {
        $this->queueManager = $managerFactory->playlistEditor(self::MAIN_PLAYLIST_ID);
    }

    public function clear(): void
    {
        $this->queueManager->clear();
    }

    public function add(AudioReadModel ...$audios): void
    {
        $this->queueManager->add(...$audios);
    }

    public function remove(AudioReadModel $audio): void
    {
        $this->queueManager->remove($audio);
    }
}