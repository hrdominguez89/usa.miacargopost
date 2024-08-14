<?php

namespace App\Pagination;

use Knp\Component\Pager\Pagination\PaginationInterface;

interface PaginationRepositoryInterface
{
    public function findAllPaginated(
        array $c,
        array $o,
        array $s,
        int $l = 100,
        int $p = 1
    ): PaginationInterface;
}
