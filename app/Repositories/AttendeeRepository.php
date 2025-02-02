<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Interfaces\DBConnection;
use App\Exceptions\HttpException;
use App\Helpers\Paginator;
use App\Repositories\Interfaces\Repository;

class AttendeeRepository implements Repository
{
    public function __construct(private DBConnection $db) {}

    public function paginate(array $filter = [], bool $isPublic = false): array
    {
        $perPage = $filter['limit'] ?? 20;
        $currentPage = $filter['page'] ?? 1;
        $offset = ($currentPage - 1) * $perPage;

        $searchValue = $filter['s'] ?? '';
        $whereClause = $searchValue !== '' ? "WHERE name Like :nameLikeSearch OR email Like :emailLikeSearch" : "";
        $params = $searchValue !== '' ? [
            ':nameLikeSearch' => "%{$searchValue}%",
            ':emailLikeSearch' => "%{$searchValue}%",
        ] : [];

        if (empty($whereClause)) {
            $whereClause = "WHERE `event_id` = :event_id";
        } else {
            $whereClause .= " AND `event_id` = :event_id";
        }
        $params[':event_id'] = $filter['event_id'];



        $countSql = sprintf(
            'SELECT COUNT(*) AS total FROM `attendees` %s',
            $whereClause
        );

        $total = (int)$this->db->statement($countSql, $params)->fetchColumn();

        $order = $filter['order'] ?? 'created_at';
        $direction = strtoupper($filter['dir'] ?? '') === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT * FROM `attendees` {$whereClause} ORDER BY `$order` $direction LIMIT $perPage OFFSET $offset";
        $stmt = $this->db->statement($sql, $params);
        $data = $stmt->fetchAll();

        return Paginator::paginate($data, $total, (int)$perPage, (int)$currentPage);
    }

    public function getAll(int $eventId)
    {
        $sql = "SELECT `id`, `name`, `email`, `created_at` FROM `attendees` WHERE `event_id` = :event_id ORDER BY `created_at` ASC";

        $stmt = $this->db->statement($sql, [':event_id' => $eventId]);

        if ($stmt === false) {
            throw new HttpException("Failed to fetch attendees");
        }
        return $stmt->fetchAll();
    }

    public function create(array $data = [])
    {
        $valuePlaceholders = array_map(fn($col) => ":$col", array_keys($data));

        $sql = sprintf(
            'INSERT INTO `attendees` (%s) VALUES (%s)',
            implode(', ', array_keys($data)),
            implode(', ', $valuePlaceholders)
        );
        $stmt = $this->db->statement($sql, $data);
        if ($stmt !== false && $stmt->rowCount() > 0) {
            return $this->db->lastInsertId();
        }

        throw new HttpException("Failed to register in the event");
    }

    public function countTotalAttendees(int $eventId)
    {
        $countSql = 'SELECT COUNT(*) AS total FROM `attendees` WHERE `event_id` = :event_id';

        $stmt = $this->db->statement($countSql, [':event_id' => $eventId]);

        if ($stmt === false) {
            throw new HttpException("Failed to get total count of attendees");
        }

        return $stmt->fetchColumn();
    }

    public function isExist($value, $key = 'email')
    {
        $sql = "SELECT COUNT(*) FROM `attendees` WHERE `{$key}` = :{$key}";
        $stmt = $this->db->statement($sql, [$key => $value]);

        return $stmt->fetchColumn() > 0;
    }

    public function delete(int $eventId, int $id)
    {
        $sql = sprintf(
            'DELETE FROM `attendees` WHERE `id` = :id AND `event_id` = :event_id',
        );
        $params = [
            ':id' => $id,
            ':event_id' => $eventId,
        ];
        $stmt = $this->db->statement($sql, $params);
        if ($stmt !== false && $stmt->rowCount() > 0) {
            return true;
        }

        throw new HttpException("Failed to delete attendee");
    }
}
