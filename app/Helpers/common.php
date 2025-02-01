<?php

if (!function_exists('dd')) {
    function dd(...$vars)
    {
        echo "<pre>";
        foreach ($vars as $var) {
            var_dump($var);
        }
        exit();
    }
}

if (!function_exists('input_value')) {
    function input_value(mixed $value = null, mixed $old = null, mixed $default = null)
    {
        if ($old !== null) {
            return $old;
        } elseif ($value !== null) {
            return $value;
        }

        return $default;
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        $csrf = bin2hex(random_bytes(16));
        $_SESSION['csrf_token'] = $csrf;
        return $csrf;
    }
}

if (!function_exists('get_csrf_token')) {
    function get_csrf_token(): ?string
    {
        return isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : null;
    }
}

if (!function_exists('csrf')) {
    function csrf(): string
    {
        $csrfToken = csrf_token();
        return "<input type=\"hidden\" name=\"csrf_token\" value=\"{$csrfToken}\" />";
    }
}
