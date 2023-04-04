<?php

namespace App\Models;

use CodeIgniter\Model;

class DistrictsModel extends Model
{
    protected $table      = 'districts';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id', 'regency_id', 'name'];
}
