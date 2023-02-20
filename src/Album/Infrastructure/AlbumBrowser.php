<?php

declare(strict_types=1);

namespace App\Album\Infrastructure;

use App\Album\Application\AlbumBrowserInterface;
use App\Album\Application\AlbumFactory;
use App\Library\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;


class AlbumBrowser implements AlbumBrowserInterface
{

    public function __construct(
        private EntityManagerInterface $em,
        private AlbumFactory           $albumFactory
    )
    {
    }

    public function albumsIndex(): array
    {
        $qb = $this->em
            ->createQueryBuilder()
            ->from(AudioEntity::class, 'a')
            ->select('a.album')
            ->distinct();

        $results = $qb->getQuery()->getSingleColumnResult();

        return array_map(
            fn(string $albumName) => $this->albumFactory->createAlbum($albumName),
            $results
        );
    }

    /**
     * @inheritDoc
     */
    public function findAlbumAudios(string $albumName): array
    {

        return array_map(
            fn(AudioEntity $audio) => $audio->readModel(),
            $results
        );
    }
}
