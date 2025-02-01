<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Core\Request;
use App\Core\Response;
use App\Helpers\Auth as AuthHelper;
use App\Middlewares\Interfaces\Middleware;

class PreventIfAuthenticated implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        if (AuthHelper::check()) {
            Response::redirect('/events');
        }

        return $next($request);
    }
}
