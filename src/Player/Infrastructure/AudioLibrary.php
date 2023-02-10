<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Player\Application\AudioLibraryInterface;
use App\Shared\Application\Album;
use App\Shared\Application\AudioReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AudioLibrary implements AudioLibraryInterface
{
    /**
     * @var EntityRepository<AudioReadModel>
     */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repository = $this->em->getRepository(AudioReadModel::class);
    }

    public function findAudio(string $audioId): AudioReadModel
    {
        return $this->repository->find($audioId);
    }

    public function findAlbum(string $album): Album
    {
        $audios = $this->repository->findBy(['album' => $album]);

        return new Album(name: $album, audios: $audios);
    }
}
