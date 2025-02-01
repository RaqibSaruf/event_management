<?php

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'host' => $_ENV['DB_HOST'],
    'port' => (int)$_ENV['DB_PORT'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'charset' => 'utf8mb4',
    'migrations_dir' => 'migrations'
];

try {
    $newDbDsn = "mysql:host={$config['host']};charset=utf8mb4";
    $newDbPdo = new PDO($newDbDsn, $config['username'], $config['password']);
    $newDbPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $newDbPdo->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '{$config['database']}'");
    if (!$stmt->fetch()) {
        $newDbPdo->exec("
            CREATE DATABASE `{$config['database']}`
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci;
        ");

        echo "Database created successfully\n";
    }
    $newDbPdo = null;
} catch (PDOException $e) {
    die("Database creation failed: " . $e->getMessage());
}

try {
    $dir = $config['migrations_dir'];

    $dir = realpath($dir) ?: $config['migrations_dir'];

    if (!file_exists($dir)) {
        throw new Exception("Path does not exist: $dir");
    }

    $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $files = [];
    if (is_dir($dir)) {
        $files = glob("$dir/*.sql");
        natsort($files);
    }
    if (empty($files)) {
        throw new Exception("No SQL files found to process");
    }

    foreach ($files as $file) {
        echo "Processing: " . basename($file) . "\n";
        try {
            $sql = file_get_contents($file);

            $pdo->exec($sql);

            echo "Successfully applied: " . $file . "\n";
        } catch (Exception $e) {
            throw new Exception("Migration failed in file " . $file . ": " . $e->getMessage());
        }
    }
    echo "All migrations completed successfully!\n";
    exit(0);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
