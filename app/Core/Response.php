<?php

declare(strict_types=1);

namespace App\Core;

use App\Exceptions\NotFoundException;
use App\Helpers\Auth;
use App\Helpers\Session;
use App\Repositories\UserRepository;

class Response
{
    public static function view(string $view, array $data = []): string
    {
        $viewPath = __DIR__ . '/../../views/' . str_replace('.', '/', $view) . '.php';
        if (!file_exists($viewPath)) {
            http_response_code(404);
            throw new NotFoundException();
        }

        $user = null;
        if (Auth::check()) {
            $user = (new UserRepository(Database::getInstance()))->findOne(Auth::id(), 'id', ['id', 'name', 'email']);
        }

        extract([
            'request' => new Request(),
            'successMsg' => Session::successMsg(),
            'errorMsg' => Session::errorMsg(),
            'errors' => Session::errors(),
            'oldValues' => Session::oldValues(),
            'user' => $user,
            ...$data
        ]);
        ob_start();
        include $viewPath;

        return ob_get_clean();
    }

    public static function redirect(string $uri = '/'): void
    {
        header("Location: " . $uri);
        exit;
    }

    public static function reload(): void
    {
        header("Refresh: 0; url=" . $_SERVER['REQUEST_URI']);
        exit;
    }

    public static function refresh(): void
    {
        header("Refresh: 0; url=" . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public static function json(array $data, int $status = 200): string
    {
        http_response_code($status);
        header('Content-Type: application/json');
        return json_encode($data);
    }
}
