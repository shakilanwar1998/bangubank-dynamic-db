<?php

namespace App\Models;

use App\DB\Model;

class Balance extends Model
{
    protected string $fileName = 'balances.json';
    protected string $tableName = 'balances';
}