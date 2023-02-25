<?php

declare(strict_types=1);

namespace App\Album\Infrastructure;

use App\Album\Application\AlbumInfo;
use App\Album\Application\CoverStorageInterface;
use App\Album\Application\Interactor\AlbumInfoProviderInterface;
use App\Audio\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;


class AlbumInfoProvider implements AlbumInfoProviderInterface
{

    public function __construct(
        private EntityManagerInterface $em,
        private CoverStorageInterface  $coverStorage
    )
    {
    }

    public function albums(): array
    {
        $qb = $this->em
            ->createQueryBuilder()
            ->from(AudioEntity::class, 'a')
            ->select('a.album')
            ->distinct();

        $results = $qb->getQuery()->getSingleColumnResult();

        return array_map(
            function (string $albumName) {
                $coverFileName = $this->coverStorage->getCoverFileName($albumName);
                return new AlbumInfo($albumName, $coverFileName !== null);
            },
            $results
        );
    }

    /**
     * @inheritDoc
     */
    public function findAlbumAudios(string $albumName): array
    {
        $qb = $this->em
            ->createQueryBuilder()
            ->from(AudioEntity::class, 'a')
            ->select('a')
            ->where('a.album = :album')
            ->setParameter('album', $albumName)
            ->distinct();

        $results = $qb->getQuery()->getResult();

        return array_map(
            fn(AudioEntity $audio) => $audio->readModel(),
            $results
        );
    }
}
