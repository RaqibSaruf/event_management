<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface Repository
{
    public function paginate(array $filter = []): array;
}
