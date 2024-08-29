<?php

namespace App\DB;
use Exception;

class Model {
    protected DatabaseInterface $storage;
    protected string $tableName;
    protected string $fileName;

    /**
     * @throws Exception
     */
    public function __construct() {
        $config = include('config/database.php');
        $default = $config['default'];

        if ($default === 'file' && isset($config['file']['type']) && $config['file']['type'] === 'json') {
            $filePath = './data/' . ($this->fileName ?? $config['file']['path']);
            $this->storage = new JSON($filePath);
        } elseif ($default === 'mysql') {
            $mysqlConfig = $config['mysql'];
            $this->storage = new MySQL($mysqlConfig,$this->tableName);
        } else {
            throw new Exception("Unsupported storage type: $default");
        }
    }

    public function create(array $data): ?array {
        return $this->storage->create($data);
    }

    public function updateOrCreate(array $filter, array $data): ?array {
        return $this->storage->updateOrCreate($filter, $data);
    }

    public function findOne($key, $value) {
        return $this->storage->findOne($key, $value);
    }

    public function findAll(array $filters = []): ?array {
        return $this->storage->findAll($filters);
    }
}
