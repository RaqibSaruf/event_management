<?php

declare(strict_types=1);

namespace App\Helpers;

class Auth
{
    public static function login(int $userId): int
    {
        $_SESSION['user_id'] = $userId;
        return $userId;
    }

    public static function id(): int
    {
        $userId = $_SESSION['user_id'];
        return $userId ? (int) $userId : 0;
    }

    public static function check(): bool
    {
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    public static function destroy(): void
    {
        if (isset($_SESSION['user_id']))
            unset($_SESSION['user_id']);
    }
}
