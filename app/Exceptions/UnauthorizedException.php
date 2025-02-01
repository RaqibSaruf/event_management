<?php

declare(strict_types=1);

namespace App\Exceptions;

class UnauthorizedException extends HttpException
{
    public function __construct(string $message = 'Unauthorized', int $statusCode = 401)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message);
    }
}
