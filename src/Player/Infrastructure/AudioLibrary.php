<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Player\Application\AudioLibraryInterface;
use App\Shared\Application\Album;
use App\Shared\Application\Audio;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AudioLibrary implements AudioLibraryInterface
{
    /**
     * @var EntityRepository<Audio>
     */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repository = $this->em->getRepository(Audio::class);
    }

    public function findAudio(string $audioId): Audio
    {
        return $this->repository->find($audioId);
    }

    public function findAlbum(string $album): Album
    {
        $audios = $this->repository->findBy(['album' => $album]);

        return new Album(name: $album, audios: $audios);
    }
}
