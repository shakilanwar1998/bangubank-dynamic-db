<?php
namespace App\DB;

class JSON implements DatabaseInterface {
    protected string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    public function create(array $data): array {
        $fileData = json_decode(file_get_contents($this->filePath), true);
        $auto_increment = $fileData['auto_increment'] ?? 0;
        $auto_increment++;
        $fileData['auto_increment'] = $data['id'] = $auto_increment;

        $fileData['data'][] = $data;
        file_put_contents($this->filePath, json_encode($fileData));
        return $data;
    }

    public function updateOrCreate(array $filter, array $data): array {
        $db = json_decode(file_get_contents($this->filePath), true);
        $items = $db['data'] ?? array();

        $updatedItem = null;
        $itemFound = false;

        foreach ($items as &$item) {
            $matchesFilter = true;
            foreach ($filter as $key => $value) {
                if (!isset($item[$key]) || $item[$key] != $value) {
                    $matchesFilter = false;
                    break;
                }
            }

            if ($matchesFilter) {
                $item = array_merge($item, $data);
                $updatedItem = $item;
                $itemFound = true;
                break;
            }
        }

        if (!$itemFound) {
            $newItem = array_merge($filter, $data);
            $items[] = $newItem;
            $updatedItem = $newItem;
        }

        $db['data'] = $items;
        file_put_contents($this->filePath, json_encode($db, JSON_PRETTY_PRINT));

        return $updatedItem;
    }


    public function findOne($key, $value) {
        $db = json_decode(file_get_contents($this->filePath), true);
        $data = $db['data'] ?? array();
        foreach ($data as $item) {
            if (isset($item[$key]) && $item[$key] == $value) {
                return $item;
            }
        }
        return null;
    }

    public function findAll(array $filters = []): array
    {
        $db = json_decode(file_get_contents($this->filePath), true);
        $data = $db['data'] ?? [];

        if (empty($filters)) {
            return $data;
        }

        $globalOperator = strtoupper($filters['operator'] ?? 'AND');
        $conditions = $filters['conditions'] ?? [];

        $result = [];

        foreach ($data as $item) {
            $matches = 0;

            foreach ($conditions as $condition) {
                $key = $condition['key'];
                $value = $condition['value'];

                if (!isset($item[$key])) {
                    continue;
                }

                if ($item[$key] == $value) {
                    $matches++;
                }
            }

            if (
                ($globalOperator === 'AND' && $matches === count($conditions)) ||
                ($globalOperator === 'OR' && $matches > 0)
            ) {
                $result[] = $item;
            }
        }

        return $result;
    }
}
