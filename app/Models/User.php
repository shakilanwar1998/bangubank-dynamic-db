<?php

namespace App\Models;

use App\DB\Model;

class User extends Model
{
    protected string $fileName = 'users.json';
    protected string $tableName = 'users';
}