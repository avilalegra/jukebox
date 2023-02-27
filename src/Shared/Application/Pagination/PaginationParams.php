<?php

namespace App\Shared\Application\Pagination;

readonly class PaginationParams
{
    /**
     * @param int $pageNumber
     * @param int $pageLimit
     * @param array<string, mixed> $filters
     * @param array<PaginationOrder> $order
     */
    public function __construct(
        public int              $pageNumber,
        public int              $pageLimit,
        public ?PaginationOrder $order = null,
        public array            $filters = [],
    )
    {
        assert($this->pageNumber > 0);
        assert($this->pageLimit > 0);
    }

    public function offset() : int
    {
       return ($this->pageNumber - 1) * $this->pageLimit;
    }
}