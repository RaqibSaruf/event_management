<?php

declare(strict_types=1);

namespace App\Requests;

use App\Core\Request;
use App\Requests\Interfaces\MustValidate;

class LoginRequest extends Request implements MustValidate
{
    public function isValid(): bool
    {
        return $this->isValidEmail() && $this->isValidPassword();
    }

    private function isValidEmail(): bool
    {
        $email = $this->post('email');
        if (empty($email)) {
            $this->errors['email'] = 'Email is required';
            return false;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['email'] = "Please provide a valid email";
            return false;
        }

        return true;
    }

    private function isValidPassword(): bool
    {
        $password = $this->post('password');
        if (empty(trim($password))) {
            $this->errors['password'] = "Password is required";
            return false;
        }

        return true;
    }
}
