<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Request;
use App\Exceptions\UnauthorizedException;
use App\Helpers\Auth as AuthHelper;
use App\Middlewares\Interfaces\Middleware;

class CheckAuth implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        if (!AuthHelper::check()) {

            throw new UnauthorizedException();
        }

        return $next($request);
    }
}
