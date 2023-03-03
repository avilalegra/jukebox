<?php

namespace App\Playlist\Infrastructure;

use App\Playlist\Application\PlaylistEntityRepositoryInterface;
use App\Playlist\Domain\PlaylistEntity;
use App\Shared\Application\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PlaylistEntityRepository implements PlaylistEntityRepositoryInterface
{
    /** @var EntityRepository<PlaylistEntity> */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repository = $this->em->getRepository(PlaylistEntity::class);
    }

    public function update(PlaylistEntity $playlist): void
    {
        $this->em->persist($playlist);
        $this->em->flush();
    }

    /** @inheritDoc */
    public function findPlaylist(string $playlistId): PlaylistEntity
    {
        $playlist = $this->repository->find($playlistId);
        if ($playlist === null) {
            throw new EntityNotFoundException(PlaylistEntity::class, $playlistId);
        }
        return $playlist;
    }
}