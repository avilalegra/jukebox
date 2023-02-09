<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Player\Application\AudioLibraryInterface;
use App\Shared\Application\Album;
use App\Shared\Application\Audio;
use Doctrine\ORM\EntityManagerInterface;

class AudioLibrary implements AudioLibraryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function findAudio(string $audioId): Audio
    {
        $repository = $this->em->getRepository(Audio::class);

        return $repository->find($audioId);
    }

    public function findAlbum(string $id): Album
    {
        $repository = $this->em->getRepository(Album::class);

        return $repository->find($id);
    }
}
