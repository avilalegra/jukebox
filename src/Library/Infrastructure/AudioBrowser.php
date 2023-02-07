<?php

declare(strict_types=1);

namespace App\Library\Infrastructure;

use App\Library\Application\AudioBrowserInterface;
use App\Shared\Application\Album;
use Doctrine\ORM\EntityManagerInterface;

class AudioBrowser implements AudioBrowserInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function allAlbums(): array
    {
        $repository = $this->em->getRepository(Album::class);

        return $repository->findAll();
    }
}
