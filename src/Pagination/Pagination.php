<?php

namespace App\Pagination;

use Symfony\Component\HttpFoundation\Request;

final class Pagination
{

    public function paginate(Request $request, PaginationRepositoryInterface $repository): array
    {
        [$l, $p, $s, $o, $c] = [
            $request->get('length', 100),
            $request->get('start', 0),
            $request->get('search', []),
            $request->get('order', []),
            $request->get('columns', []),
        ];

        $p = ($p == 0 ? $p : ((int)($p / $l))) + 1;

        $pagination = $repository->findAllPaginated($c, $o, $s, $l, $p);

        return [
            'draw' => $request->get('draw'),
            'recordsTotal' => $pagination->getTotalItemCount(),
            'recordsFiltered' => $pagination->getTotalItemCount(),
            'data' => $pagination->getItems(),
        ];
    }


}