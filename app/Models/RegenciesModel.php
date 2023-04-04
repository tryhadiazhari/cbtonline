<?php

namespace App\Models;

use CodeIgniter\Model;

class RegenciesModel extends Model
{
    protected $table      = 'regencies';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id', 'province_id', 'name'];
}
