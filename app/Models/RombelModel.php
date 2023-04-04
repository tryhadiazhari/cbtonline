<?php

namespace App\Models;

use CodeIgniter\Model;

class RombelModel extends Model
{
    protected $table      = 'hazedu_rombel';
    protected $primaryKey = 'uid_rombel';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'uid_rombel', 'npsn', 'jenis_rombel', 'jenjang', 'tingkatan', 'kurikulum', 'nama', 'wali_kelas', 'ruang'
    ];
}
