<?php

$config = include('config/database.php');
$dbConfig = $config['mysql'];

try {
    $dsn = "mysql:host={$dbConfig['host']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$pdo->exec("CREATE DATABASE IF NOT EXISTS {$dbConfig['database']}");
$pdo->exec("USE {$dbConfig['database']}");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role INT NOT NULL
    )
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS balances (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL
    )
");

$pdo->exec("
    CREATE TABLE IF NOT EXISTS transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        from_user_id INT NULL,
        to_user_id INT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        remarks TEXT
    )
");

function insertDataFromJson($pdo, $table, $data): void
{
    foreach ($data as $row) {
        $columns = implode(", ", array_keys($row));
        $placeholders = implode(", ", array_fill(0, count($row), "?"));
        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array_values($row));
    }
}

$usersData = json_decode(file_get_contents('./data/users.json'), true)['data'];

insertDataFromJson($pdo, 'users', $usersData);

echo "Migration and data insertion completed successfully.";

