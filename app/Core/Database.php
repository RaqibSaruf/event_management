<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Interfaces\DBConnection;
use App\Exceptions\HttpException;
use PDO;
use PDOException;
use PDOStatement;

class Database implements DBConnection
{
    private static ?self $instance = null;
    private ?PDO $pdo = null;
    private array $config;

    private function __construct()
    {
        $this->config = [
            'host' => $_ENV['DB_HOST'],
            'port' => (int)$_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8mb4',
        ];

        register_shutdown_function([$this, 'disconnect']);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
            self::$instance->connect();
        }

        return self::$instance;
    }


    private function connect(): void
    {
        if ($this->pdo === null) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $this->config['host'],
                    $this->config['port'],
                    $this->config['database'],
                    $this->config['charset']
                );

                $this->pdo = new PDO(
                    $dsn,
                    $this->config['username'],
                    $this->config['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ]
                );
            } catch (PDOException $e) {
                throw new PDOException("Connection failed: " . $e->getMessage());
            }
        }
    }

    public function statement(string $sql, array $params = []): PDOStatement|false
    {
        $this->connect();
        $stmt = $this->pdo->prepare($sql);
        $this->bindValues($stmt, $params);

        if ($stmt->execute()) {
            return $stmt;
        }

        throw new HttpException("Database Error");
    }

    public function lastInsertId(): string
    {
        $this->connect();

        return $this->pdo->lastInsertId();
    }

    public function disconnect(): void
    {
        $this->pdo = null;
    }



    private function bindValues(\PDOStatement $stmt, array $params): void
    {
        foreach ($params as $key => $value) {
            $type = match (true) {
                is_int($value) => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default => PDO::PARAM_STR,
            };
            $stmt->bindValue($key, $value, $type);
        }
    }
}
