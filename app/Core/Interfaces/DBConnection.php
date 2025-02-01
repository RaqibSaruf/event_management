<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

use PDOStatement;

interface DBConnection
{
    public function statement(string $sql, array $params = []): PDOStatement|false;
    public function lastInsertId(): string;
}
