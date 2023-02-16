<?php

namespace App\Library\Infrastructure;

use App\Library\Domain\AudioEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class AudioEntityRepository implements \App\Library\Application\AudioEntityRepositoryInterface
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
}