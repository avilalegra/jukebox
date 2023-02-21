<?php

namespace App\Library\Infrastructure;

use App\Library\Application\AudioEntityRepositoryInterface;
use App\Library\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class AudioEntityRepository implements AudioEntityRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
    }

    public function add(AudioEntity $audio): void
    {
        $this->em->persist($audio);
        $this->em->flush();
    }

    public function find(string $audioId): AudioEntity
    {
        return $this->em->find(AudioEntity::class, $audioId);
    }
}