<?php

namespace App\Models;

use CodeIgniter\Model;

class VillagesModel extends Model
{
    protected $table      = 'villages';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id', 'district_id', 'name'];
}
