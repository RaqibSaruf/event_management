<?php

declare(strict_types=1);

namespace App\Requests;

use App\Core\Request;
use App\Repositories\UserRepository;
use App\Requests\Interfaces\MustValidate;

class RegisterRequest extends Request implements MustValidate
{
    public function __construct(private UserRepository $userRepo)
    {
        parent::__construct();
    }

    public function isValid(): bool
    {
        return $this->isValidName() && $this->isValidEmail() && $this->isValidPassword();
    }

    private function isValidName(): bool
    {
        $name = trim($this->post('name'));
        if (strlen($name) < 3) {
            $this->errors['name'] = 'Name must be at least 3 characters';
            return false;
        } else if (strlen($name) > 255) {
            $this->errors['name'] = "Name can be max 255 characters";
            return false;
        }

        return true;
    }

    private function isValidEmail(): bool
    {
        $email = trim($this->post('email'));
        if (empty($email)) {
            $this->errors['email'] = 'Email is required';
            return false;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Please provide a valid email";
            return false;
        } else if (strlen($email) > 255) {
            $this->errors['email'] = "Email can be max 255 characters";
            return false;
        } else if ($this->userRepo->isExist($email, 'email')) {
            $this->errors['email'] = "Email Already exists";
            return false;
        }

        return true;
    }

    private function isValidPassword(): bool
    {
        $password = trim($this->post('password'));
        $passwordConfirmation = $this->post('password_confirmation');
        if (strlen($password) < 6) {
            $this->errors['password'] = "Password must be at least 3 characters";
            return false;
        } else if (strlen($password) > 60) {
            $this->errors['password'] = "Password can be max 60 characters";
            return false;
        } else if ($password !== $passwordConfirmation) {
            $this->errors['password_confirmation'] = "Passwords do not match";
            return false;
        }

        return true;
    }
}
