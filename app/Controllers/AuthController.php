<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Response;
use App\Exceptions\ValidationException;
use App\Helpers\Auth;
use App\Repositories\UserRepository;
use App\Requests\LoginRequest;

class AuthController extends BaseController
{
    public function __construct(private UserRepository $userRepo) {}

    public function loginForm()
    {
        return Response::view('Auth/LoginForm');
    }

    public function login(LoginRequest $request)
    {
        if (!$request->isValid()) {
            throw new ValidationException($request->errors, $request->post());
        }

        $user = $this->userRepo->findOne($request->post('email'), 'email');
        if ($user === false || !password_verify($request->post('password'), $user->password)) {
            $request->errors['email'] = 'Provided email or password not matched';
            throw new ValidationException($request->errors, $request->post());
        }

        Auth::login($user->id);

        Response::redirect("/events");
    }

    public function logout()
    {
        Auth::destroy();

        Response::redirect("/login");
    }
}
