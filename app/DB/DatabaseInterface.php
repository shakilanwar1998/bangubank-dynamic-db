<?php
namespace App\DB;

interface DatabaseInterface {
    public function create(array $data): array;
    public function updateOrCreate(array $filter, array $data): array;
    public function findOne($key, $value);
    public function findAll(array $filters = []): array;
}
