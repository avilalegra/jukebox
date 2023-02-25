<?php

namespace App\Player\Infrastructure;

use App\Player\Application\Interactor\PlayerStatusInfoProviderInterface;
use App\Player\Application\Player\Status\AudioPlayingStatusRepositoryInterface;
use App\Player\Application\Player\Status\PlayerStatus;
use App\Playlist\Application\Interactor\PlaylistInfoProviderInterface;
use App\Playlist\Domain\PlaylistEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PlayerStatusInfoProvider implements PlayerStatusInfoProviderInterface
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
            audioPlayStatus: $this->playingStatusRepository->status(),
            queue: $this->playlistInfoProvider->findPlaylist('main')
        );
    }
}