<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Helpers\Auth;
use App\Repositories\UserRepository;
use App\Requests\RegisterRequest;

class RegisterController extends BaseController
{
    public function __construct(private UserRepository $userRepo) {}

    public function registerForm()
    {
        return Response::view('Auth/RegisterForm');
    }

    public function register(RegisterRequest $request)
    {
        if (!$request->isValid()) {
            throw new ValidationException($request->errors, $request->post());
        }

        $data = [
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => password_hash($request->post('password'), PASSWORD_BCRYPT),
        ];
        $userId = $this->userRepo->create($data);

        Auth::login((int)$userId);

        Response::redirect("/events");
    }
}
