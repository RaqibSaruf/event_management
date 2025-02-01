<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    protected array $query;
    protected array $body;
    public array $errors = [];

    public function __construct()
    {
        $this->query = $_GET ?? [];
        $this->body = $this->getBody();
    }

    private function getBody(): array
    {
        switch ($this->method()) {
            case "POST":
                return $_POST ?? [];
            case "PUT":
            case "PATCH":
            case "DELETE":
                $body = [];
                parse_str(file_get_contents("php://input"), $body);
                return $body;
            default:
                return [];
        }
    }

    public function method()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isMethod(string $method)
    {
        return $this->method() === strtoupper($method);
    }

    public function uri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function get(string $key = '', $default = null): mixed
    {
        if ($key === '') {
            return $this->query;
        }
        return $this->query[$key] ?? $default;
    }

    public function post(string $key = '', $default = null): mixed
    {
        if ($key === '') {
            return $this->body;
        }

        return $this->body[$key] ?? $default;
    }

    public function input(string $key = '', $default = null): mixed
    {
        $input =  array_merge($this->get(), $this->post());

        if ($key === '') {
            return $input;
        }

        return $input[$key] ?? $default;
    }
}
