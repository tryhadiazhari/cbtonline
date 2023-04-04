<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisUjianModel extends Model
{
    protected $table      = 'hazedu_jenis_ujian';
    protected $primaryKey = 'uid_jenis';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['uid_jenis', 'npsn', 'nama', 'alias', 'status'];
}
