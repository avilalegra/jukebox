<?php

namespace App\Shared\Application\Pagination;

readonly class PaginationOrder
{
    public static function asc(string $field): self
    {
        return new self($field, 'asc');
    }

    public static function desc(string $field): self
    {
        return new self($field, 'desc');
    }

    private function __construct(
        public string $field,
        public string $direction
    )
    {
    }
}