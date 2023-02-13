<?php

declare(strict_types=1);

namespace App\Player\Infrastructure;

use App\Library\Domain\AudioEntity;
use App\Player\Application\AudioLibraryInterface;
use App\Shared\Domain\AudioReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AudioLibrary implements AudioLibraryInterface
{
    /**
     * @var EntityRepository<AudioEntity>
     */
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repository = $this->em->getRepository(AudioEntity::class);
    }

    public function findAudio(string $audioId): AudioReadModel
    {
        return $this->repository->find($audioId)->readModel();
    }
}
