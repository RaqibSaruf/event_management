<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Interfaces\DBConnection;
use App\Exceptions\HttpException;
use App\Exceptions\NotFoundException;
use App\Helpers\Auth;
use App\Helpers\Paginator;
use App\Repositories\Interfaces\Repository;

class EventRepository implements Repository
{
    public function __construct(private DBConnection $db) {}

    public function paginate(array $filter = []): array
    {
        $perPage = $filter['limit'] ?? 20;
        $currentPage = $filter['page'] ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $searchValue = $filter['s'] ?? '';
        $whereClause = $searchValue !== '' ? "WHERE name Like :namelikeSearch" : "";
        $params = $searchValue !== '' ? [':namelikeSearch' => "%{$searchValue}%"] : [];

        if (Auth::check()) {
            if (empty($whereClause)) {
                $whereClause = "WHERE `created_by` = :created_by";
            } else {
                $whereClause .= " AND `created_by` = :created_by";
            }
            $params[':created_by'] = Auth::id();
        }


        $countSql = sprintf(
            'SELECT COUNT(*) AS total FROM `events` %s',
            $whereClause
        );

        $total = (int)$this->db->statement($countSql, $params)->fetchColumn();

        $order = $filter['order'] ?? 'created_at';
        $direction = strtoupper($filter['dir'] ?? '') === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM `events` {$whereClause} ORDER BY `$order` $direction LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->statement($sql, $params);
        $data = $stmt->fetchAll();

        return Paginator::paginate($data, $total, (int)$perPage, (int)$currentPage);
    }

    public function findOne($value, $key = 'id', array $selectFields = ['*'], bool $failedIfnotFound = false): object|false
    {
        $select = implode(", ", $selectFields);
        $sql = "SELECT {$select} FROM `events` WHERE `{$key}` = :{$key}";
        $params = [":{$key}" => $value];

        if (Auth::check()) {
            $sql .= " AND `created_by` = :created_by";
            $params[':created_by'] = Auth::id();
        }

        $stmt = $this->db->statement($sql, $params);

        $event = $stmt->fetchObject();
        if ($failedIfnotFound && $event === false) {
            throw new NotFoundException("Event not found");
        }

        return $event;
    }

    public function create(array $data = [])
    {
        $data['created_by'] = Auth::id();
        $valuePlaceholders = array_map(fn($col) => ":$col", array_keys($data));

        $sql = sprintf(
            'INSERT INTO `events` (%s) VALUES (%s)',
            implode(', ', array_keys($data)),
            implode(', ', $valuePlaceholders)
        );
        $stmt = $this->db->statement($sql, $data);
        if ($stmt !== false) {
            return $this->db->lastInsertId();
        }

        throw new HttpException("Failed to create Event");
    }

    public function update(int $id, array $data = []): bool
    {
        $set = [];
        $param = [];
        foreach ($data as $column => $value) {
            $set[] = "`{$column}`" . ' = :' . $column;
            $param[":{$column}"] = $value;
        }
        $sql = sprintf(
            'UPDATE `events` SET %s WHERE id = %s',
            implode(', ', $set),
            $id
        );


        $stmt = $this->db->statement($sql, $param);

        if ($stmt !== false) {
            return true;
        }

        throw new HttpException("Failed to update this event");
    }

    public function delete(int $id)
    {
        $sql = sprintf(
            'DELETE FROM `events` WHERE `id` = :id AND `created_by` = :created_by',
        );
        $params = [
            ':id' => $id,
            ':created_by' => Auth::id()
        ];
        $stmt = $this->db->statement($sql, $params);
        if ($stmt !== false) {
            return true;
        }

        throw new HttpException("Failed to delete this event");
    }
}
