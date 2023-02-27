<?php

namespace App\Audio\Application\Interactor;

use App\Audio\Domain\AudioReadModel;
use App\Shared\Application\Pagination\PaginationParams;
use App\Shared\Application\Pagination\PaginationResults;

interface AudioInfoProviderInterface
{
    public function findAudio(string $audioId): AudioReadModel;

    public function paginateAudios(PaginationParams $params) : PaginationResults;
}