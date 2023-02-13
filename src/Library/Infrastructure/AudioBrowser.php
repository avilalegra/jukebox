<?php

declare(strict_types=1);

namespace App\Library\Infrastructure;

use App\Library\Application\AudioBrowserInterface;
use App\Library\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;

class AudioBrowser implements AudioBrowserInterface
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
