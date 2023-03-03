<?php

namespace App\Shared\WebUI;

use App\Shared\Application\Pagination\PaginationOrder;
use App\Shared\Application\Pagination\PaginationParams;
use Symfony\Component\HttpFoundation\Request;

trait PaginationParamsTrait
{
    private function parsePaginationParams(Request $request, int $defaultPageLimit = 12): PaginationParams
    {
        $pageNum = $request->get('page', 1);
        $limit = $request->get('limit', $defaultPageLimit);
        $order = null;

        if ($request->get('orderBy') !== null) {
            try {
                [$field, $dir] = explode(',', $request->get('orderBy'));

                $order = match ($dir) {
                    'desc' => PaginationOrder::desc($field),
                    default => PaginationOrder::asc($field)
                };
            } catch (\Throwable $_) {
            }
        }

        return new PaginationParams($pageNum, $limit, $order);
    }
}