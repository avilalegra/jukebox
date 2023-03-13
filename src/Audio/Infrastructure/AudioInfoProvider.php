<?php

namespace App\Audio\Infrastructure;

use App\Audio\Application\AudioFile\AudioStorage;
use App\Audio\Application\Interactor\AudioInfoProviderInterface;
use App\Audio\Domain\AudioEntity;
use App\Audio\Domain\AudioFile;
use App\Audio\Domain\AudioReadModel;
use App\Shared\Application\Pagination\PaginationOrder;
use App\Shared\Application\Pagination\PaginationParams;
use App\Shared\Application\Pagination\PaginationResults;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class AudioInfoProvider implements AudioInfoProviderInterface
{
    /**
     * @var EntityRepository<AudioEntity>
     */
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly AudioStorage           $audioStorage
    )
    {
        $this->repository = $this->em->getRepository(AudioEntity::class);
    }

    public function findAudio(string $audioId): AudioReadModel
    {
        return $this->repository->find($audioId)->readModel();
    }

    public function findAudioFile(AudioReadModel $audio): AudioFile
    {
        return $this->audioStorage->findAudioFile($audio);
    }


    public function paginateAudios(PaginationParams $params): PaginationResults
    {
        $qb = $this->repository->createQueryBuilder('a');
        $order = $params->order === null ? PaginationOrder::asc('title') : $params->order;

        $qb
            ->orderBy('a.' . $order->field, $order->direction);

        foreach ($params->filters as $field => $value) {
            $qb->andWhere("a.{$field} LIKE :{$field}")
                ->setParameter($field, "%$value%");
        }

        $totalCount = $qb->select('count(a.id)')->getQuery()->getSingleScalarResult();

        $qb
            ->select('a')
            ->setFirstResult($params->offset())
            ->setMaxResults($params->pageLimit);

        $audios = $qb->getQuery()->getResult();
        $audios = array_map(fn(AudioEntity $a) => $a->readModel(), $audios);

        return new PaginationResults(params: $params, pageResults: $audios, totalResultsCount: $totalCount);
    }
}