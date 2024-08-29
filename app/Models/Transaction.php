<?php

namespace App\Models;

use App\DB\Model;

class Transaction extends Model
{
    protected string $fileName = 'transactions.json';
    protected string $tableName = 'transactions';
}