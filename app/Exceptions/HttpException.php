<?php

declare(strict_types=1);

namespace App\Exceptions;


class HttpException extends \Exception
{
    protected int $statusCode = 500;

    public function __construct(
        string $message = 'Interner Server Error',
        \Throwable $previous = null
    ) {
        parent::__construct($message, $this->statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
