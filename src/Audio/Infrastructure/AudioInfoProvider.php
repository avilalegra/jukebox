<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Audio\Domain\AudioEntity;
use App\Shared\Domain\AudioReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AudioInfoProvider implements AudioInfoProviderInterface
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

    public function paginateAudios(): array
    {
        $audios = $this->repository->findAll();

        return array_map(fn(AudioEntity $a) => $a->readModel(), $audios);
    }
}