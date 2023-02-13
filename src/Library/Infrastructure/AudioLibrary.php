<?php

declare(strict_types=1);

namespace App\Library\Infrastructure;

use App\Library\Application\AudioLibraryInterface;
use App\Library\Domain\AudioEntity;
use App\Shared\Domain\AudioReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AudioLibrary implements AudioLibraryInterface
{

    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function albumNamesIndex(): array
    {
        $qb = $this->em
            ->createQueryBuilder()
            ->from(AudioEntity::class, 'a')
            ->select('a.album')
            ->distinct();

        return $qb->getQuery()->getSingleColumnResult();
    }
}
