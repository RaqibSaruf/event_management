<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;

class HomeController extends BaseController
{
    public function home()
    {
        return Response::view('Home', ['isPublic' => true]);
    }
}
