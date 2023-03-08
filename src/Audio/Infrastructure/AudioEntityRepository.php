<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Domain\AudioEntity;
use App\Audio\Domain\AudioReadModel;
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

    public function find(string $audioId): AudioEntity
    {
        return $this->repository->find($audioId);
    }

    public function hasOneWithSameTitleAndDuration(AudioEntity $audio): bool
    {
        $same = $this->repository->findOneBy(
            [
                'title' => $audio->title(),
                'duration' => $audio->duration()
            ]);

        return $same !== null;
    }

    public function remove(AudioEntity $audio): void
    {
        $this->em->remove($audio);
        $this->em->flush();
    }
}