<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table      = 'hazedu_pengumuman';
    protected $primaryKey = 'uid';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['uid', 'type', 'judul', 'user', 'text', 'crdate', 'upddate'];
}
