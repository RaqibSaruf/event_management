<?php

declare(strict_types=1);

namespace App\Helpers;

class Paginator
{
    public static function paginate(
        array $data,
        int $total,
        int $perPage,
        int $currentPage = 1,
    ): array {
        $lastPage = max(1, ceil($total / $perPage));
        return [
            'data' => $data,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $currentPage,
            'next_page' => $currentPage < $lastPage ? $currentPage + 1 : null,
            'prev_page' => $currentPage > 1 ? $currentPage - 1 : null,
            'last_page' => $lastPage,
        ];
    }
}
