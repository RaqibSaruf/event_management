<?php

namespace App\Core;

use App\Exceptions\Exception;
use Throwable;

class ExceptionHandler
{
    public static function handle(Throwable $exception): void
    {
        try {
            if (method_exists($exception, 'handle')) {
                $exception->handle();
                return;
            }

            $statusCode = method_exists($exception, 'getStatusCode')
                ? $exception->getStatusCode()
                : 500;

            $errors = method_exists($exception, 'getErrors')
                ? $exception->getErrors()
                : [];

            http_response_code($statusCode);
            if (php_sapi_name() === 'cli') {
                echo "Error: " . $exception->getMessage() . PHP_EOL;
                if ($statusCode !== 422) {
                    print_r($errors);
                }
            } else {
                if (str_contains($_SERVER['REQUEST_URI'], '/api/')) {
                    echo json_encode([
                        'message' => $exception->getMessage(),
                        'statusCode' => $statusCode,
                        'errors' => $errors
                    ]);
                } else {
                    if ($statusCode === 422) {
                        Response::redirect($_SERVER['HTTP_REFERER']);
                    }
                    echo Response::view("errors.{$statusCode}", [
                        'logMessage' => sprintf(
                            "[%s]<br/>%s<br/> in %s:%d<br/>Stack trace:<br/>%s",
                            get_class($exception),
                            $exception->getMessage(),
                            $exception->getFile(),
                            $exception->getLine(),
                            $exception->getTraceAsString()
                        ),
                        'message' => $exception->getMessage(),
                        'statusCode' => $statusCode,
                        'errors' => $errors
                    ]);
                }
            }
        } catch (Throwable $e) {
            die("Critical error: Unable to render error page");
        }
    }
}
