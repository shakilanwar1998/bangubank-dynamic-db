<?php
namespace App\DB;

use PDO;
use PDOException;

class MySQL implements DatabaseInterface {
    protected PDO $pdo;
    public function __construct(array $config, protected string $table) {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public function create(array $data): array {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        $stmt->execute(array_values($data));
        $data['id'] = $this->pdo->lastInsertId();
        return $data;
    }

    public function updateOrCreate(array $filter, array $data): array {
        $filterConditions = [];
        $filterValues = [];
        foreach ($filter as $key => $value) {
            $filterConditions[] = "{$key} = ?";
            $filterValues[] = $value;
        }
        $filterSql = implode(' AND ', $filterConditions);

        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$filterSql} LIMIT 1");
        $stmt->execute($filterValues);
        $existingRecord = $stmt->fetch();

        if ($existingRecord) {
            $setParts = [];
            $updateValues = [];
            foreach ($data as $key => $value) {
                $setParts[] = "{$key} = ?";
                $updateValues[] = $value;
            }
            $updateSql = implode(', ', $setParts);
            $stmt = $this->pdo->prepare("UPDATE {$this->table} SET {$updateSql} WHERE {$filterSql}");
            $stmt->execute(array_merge($updateValues, $filterValues));

            return array_merge($existingRecord, $data);
        } else {
            $newData = array_merge($filter, $data);
            return $this->create($newData);
        }
    }

    public function findOne($key, $value) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$key} = ?");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }


    public function findAll(array $filters = []): array {
        $sql = "SELECT * FROM {$this->table}";
        $values = [];

        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $filter) {
                if (isset($filter['key'], $filter['value'])) {
                    $operator = $filter['operator'] ?? '=';
                    $conditions[] = "{$filter['key']} {$operator} ?";
                    $values[] = $filter['value'];
                }
            }

            if ($conditions) {
                $sql .= ' WHERE ' . implode(' AND ', $conditions);
            }
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        return $stmt->fetchAll();
    }
}
