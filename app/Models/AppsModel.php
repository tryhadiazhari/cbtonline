<?php

namespace App\Models;

use CodeIgniter\Model;

class AppsModel extends Model
{
    protected $table      = 'hazedu_apps';
    protected $primaryKey = 'uid';
    protected $useAutoIncrement = true;
    protected $useTimestamps = false;
}
