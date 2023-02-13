<?php

namespace App\Library\Infrastructure;

use App\Library\Application\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class AudioEntityRepository implements \App\Library\Application\AudioEntityRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(
        private EntityManagerInterface $em
    )
    {
        $this->repository = $em->getRepository(AudioEntity::class);
    }

    public function add(AudioEntity $audio): void
    {
        $this->em->persist($audio);
        $this->em->flush();
    }
}