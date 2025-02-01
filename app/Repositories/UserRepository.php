<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Interfaces\DBConnection;
use App\Exceptions\HttpException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\Repository;

class UserRepository implements Repository
{
    public function __construct(private DBConnection $db) {}

    public function paginate(array $filter = []): array
    {
        return [];
    }

    public function isExist($value, $key = 'email')
    {
        $sql = "SELECT COUNT(*) FROM `users` WHERE `{$key}` = :{$key}";
        $stmt = $this->db->statement($sql, [$key => $value]);

        return $stmt->fetchColumn() > 0;
    }

    public function findOne($value, $key = 'id', array $selectFields = ['*'], bool $failedIfnotFound = false): object|false
    {
        $select = implode(", ", $selectFields);
        $sql = "SELECT {$select} FROM `users` WHERE `{$key}` = :{$key}";
        $stmt = $this->db->statement($sql, [$key => $value]);

        $user = $stmt->fetchObject();
        if ($failedIfnotFound && $user === false) {
            throw new NotFoundException("User not found");
        }

        return $user;
    }

    public function create(array $data = [])
    {
        $valuePlaceholders = array_map(fn($col) => ":$col", array_keys($data));

        $sql = sprintf(
            'INSERT INTO `users` (%s) VALUES (%s)',
            implode(', ', array_keys($data)),
            implode(', ', $valuePlaceholders)
        );
        $stmt = $this->db->statement($sql, $data);
        if ($stmt !== false && $stmt->rowCount() > 0) {
            return $this->db->lastInsertId();
        }

        throw new HttpException("Failed to create User");
    }
}
