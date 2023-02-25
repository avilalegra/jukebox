<?php

namespace App\Player\Application\Player;

use App\Player\Application\Interactor\PlayerQueueInterface;
use App\Playlist\Application\PlaylistManager;
use App\Playlist\Application\PlaylistManagerFactory;
use App\Shared\Domain\AudioReadModel;

class PlayerQueue implements PlayerQueueInterface
{
    private PlaylistManager $queueManager;

    public function __construct(
        PlaylistManagerFactory $managerFactory
    )
    {
        $this->queueManager = $managerFactory->playlistEditor('main');
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