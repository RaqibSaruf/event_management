<?php

declare(strict_types=1);

namespace App\Requests\Interfaces;

interface MustValidate
{
    public function isValid(): bool;
}
