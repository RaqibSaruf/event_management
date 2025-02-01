<?php

declare(strict_types=1);

namespace App\Helpers;

class Session
{
    public static function setAuth(array|null $data = null): void
    {
        $_SESSION['auth'] = $data;
    }
    public static function auth(): ?array
    {
        if (isset($_SESSION['auth'])) {
            return $_SESSION['auth'];
        }

        return  null;
    }

    public static function setSuccess(string $successMsg = ''): void
    {
        $_SESSION['success_msg'] = $successMsg;
    }

    public static function successMsg(): string
    {
        $successMsg = '';
        if (isset($_SESSION['success_msg'])) {
            $successMsg = $_SESSION['success_msg'];
            unset($_SESSION['success_msg']);
        }

        return $successMsg;
    }

    public static function setError(string $msg, array $errors = []): void
    {
        $_SESSION['error_msg'] = $msg;
        $_SESSION['errors'] = $errors;
    }

    public static function errorMsg(): string
    {
        $errorMsg = '';
        if (isset($_SESSION['error_msg'])) {
            $errorMsg = $_SESSION['error_msg'];
            unset($_SESSION['error_msg']);
        }

        return $errorMsg;
    }

    public static function errors(): array
    {
        $errors = [];
        if (isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        return $errors;
    }

    public static function setOldValues(array $oldValues = []): void
    {
        $_SESSION['old_values'] = $oldValues;
    }

    public static function oldValues(): array
    {
        $oldValues = [];
        if (isset($_SESSION['old_values'])) {
            $oldValues = $_SESSION['old_values'];
            unset($_SESSION['old_values']);
        }

        return $oldValues;
    }
}
