<?php

namespace App\Album\Infrastructure;

use App\Album\Application\AlbumRepositoryInterface;
use App\Album\Domain\Album;
use App\Library\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;

class AlbumRepository implements AlbumRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function findAlbum(string $name): Album
    {
        $qb = $this->em
            ->createQueryBuilder()
            ->from(AudioEntity::class, 'a')
            ->select('a')
            ->where("a.album = :name")
            ->setParameter('name', $name);

        $audios = $qb->getQuery()->getResult();

        return new Album(name: $name, audios: $audios);
    }
}