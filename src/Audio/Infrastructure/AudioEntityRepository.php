<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioEntityRepositoryInterface;
use App\Audio\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;


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