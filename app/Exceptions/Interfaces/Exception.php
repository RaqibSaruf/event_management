<?php

declare(strict_types=1);

namespace App\Exceptions\Interfaces;

interface Exception
{
    public function handle(): void;
}
