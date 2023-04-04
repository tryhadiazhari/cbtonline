<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model
{
    protected $table      = 'provinces';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id', 'name'];
}
