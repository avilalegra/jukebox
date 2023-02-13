<?php

namespace App\Playlist\Infrastructure;

use App\Playlist\Application\PlayListBrowserInterface;
use App\Playlist\Domain\PlaylistEntity;
use App\Playlist\Domain\PlaylistReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PlaylistBrowser implements PlayListBrowserInterface
{
    /**
     * @var EntityRepository<PlaylistEntity>
     */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repository = $this->em->getRepository(PlaylistEntity::class);
    }

    public function mainPlaylist(): PlaylistReadModel
    {
        return $this->repository->findOneBy(['name' => 'main'])->readModel();
    }
}