<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    protected array $query;
    protected array $body;
    public array $errors = [];
    public string $errorMsg = '';

    public function __construct()
    {
        $this->query = $_GET ?? [];
        $this->body = $this->getBody();
    }

    private function getBody(): array
    {
        switch ($this->method()) {
            case "POST":
                if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
                    return json_decode(file_get_contents("php://input"), true);
                }
                return $_POST ?? [];
            case "PUT":
            case "PATCH":
            case "DELETE":
                if ($_SERVER['HTTP_CONTENT_TYPE'] === 'application/json') {
                    return json_decode(file_get_contents("php://input"), true);
                }
                $body = [];
                parse_str(file_get_contents("php://input"), $body);
                return $body;
            default:
                return [];
        }
    }

    public function method()
    {
        $requestedMethod = strtoupper($_SERVER['REQUEST_METHOD']);

        if ($requestedMethod === 'POST' && isset($_POST['_method'])) {
            return strtoupper($_POST['_method']);
        }
        return $requestedMethod;
    }

    public function isMethod(string $method)
    {
        return $this->method() === strtoupper($method);
    }

    public function uri()
    {
        $parseBaseUrl = parse_url(BASE_URL, PHP_URL_PATH) ?? '';
        $parseUri =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        return str_replace($parseBaseUrl, '', $parseUri);
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

    public function has($key)
    {
        $input =  array_merge($this->get(), $this->post());

        return isset($input['key']);
    }
}
