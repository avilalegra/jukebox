<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Domain\AudioEntity;
use App\Shared\Application\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class AudioEntityRepository implements AudioEntityRepositoryInterface
{
    /** @var EntityRepository<AudioEntity> */
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $em
    )
    {
        $this->repository = $em->getRepository(AudioEntity::class);
    }

    public function add(AudioEntity $audio): void
    {
        $this->em->persist($audio);
        $this->em->flush();
    }

    /** @inheritDoc */
    public function find(string $audioId): AudioEntity
    {
        $audio = $this->repository->find($audioId);
        if ($audio === null) {
            throw  new EntityNotFoundException(AudioEntity::class, $audioId);
        }

        return $audio;
    }
}