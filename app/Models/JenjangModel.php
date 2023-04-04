<?php

namespace App\Models;

use CodeIgniter\Model;

class JenjangModel extends Model
{
    protected $table      = 'hazedu_jenjang';
    protected $primaryKey = 'uid_jenjang';
    protected $useTimestamps = false;
    protected $useAutoIncrement = true;
    protected $allowedFields = ['uid_jenjang', 'jenjang'];
}
