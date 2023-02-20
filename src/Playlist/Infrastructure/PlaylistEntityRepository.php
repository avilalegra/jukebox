<?php

namespace App\Playlist\Infrastructure;

use App\Playlist\Application\PlaylistEntityRepositoryInterface;
use App\Playlist\Domain\PlaylistEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PlaylistEntityRepository implements PlaylistEntityRepositoryInterface
{
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

    public function findPlayingPlaylist(): PlaylistEntity
    {
        return $this->repository->findOneBy(['name' => 'main']);
    }
}