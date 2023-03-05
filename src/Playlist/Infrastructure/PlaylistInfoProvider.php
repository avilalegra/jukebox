<?php

namespace App\Playlist\Infrastructure;

use App\Playlist\Application\Interactor\PlaylistInfoProviderInterface;
use App\Playlist\Domain\PlaylistEntity;
use App\Playlist\Domain\PlaylistReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PlaylistInfoProvider implements PlaylistInfoProviderInterface
{
    /**
     * @var EntityRepository<PlaylistEntity>
     */
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
        $this->repository = $this->em->getRepository(PlaylistEntity::class);
    }

    public function findPlaylist(string $playlistId): PlaylistReadModel
    {
        return $this->repository->find($playlistId)->readModel();
    }
}