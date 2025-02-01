<?php

declare(strict_types=1);

namespace App\Exceptions;

class NotFoundException extends HttpException
{
    public function __construct(string $message = 'Page not found', int $statusCode = 404)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message);
    }
}
