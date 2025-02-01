<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Request;
use App\Middlewares\Interfaces\Middleware;

class VerifyCsrfToken implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        if (!$request->isMethod('get') && $request->post('csrf_token') !== get_csrf_token()) {
            throw new \Exception("CSRF token validation failed");
        }
        return $next($request);
    }
}
