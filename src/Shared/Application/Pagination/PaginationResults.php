<?php

namespace App\Shared\Application\Pagination;

readonly class PaginationResults
{
    public function __construct(
        public PaginationParams $params,
        public array            $pageResults,
        public int              $totalResultsCount
    )
    {
    }

    public function totalPages(): int
    {
        return ceil($this->totalResultsCount / $this->params->pageLimit);
    }
}