<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Helpers\Session;

class ValidationException extends HttpException
{
    public function __construct(
        protected array $errors,
        array $oldValues = [],
        string $message = 'Validation failed',
    ) {
        $this->statusCode = 422;
        Session::setError($message, $errors);
        Session::setOldValues($oldValues);
        parent::__construct($message);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
