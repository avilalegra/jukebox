<?php

namespace App\Shared\Infrastructure;

use App\Library\Domain\AudioEntity;
use App\Shared\Application\AudioBrowserInterface;
use App\Shared\Domain\AudioReadModel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class AudioBrowser implements AudioBrowserInterface
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