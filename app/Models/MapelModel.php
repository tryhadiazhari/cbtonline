<?php

namespace App\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $table      = 'hazedu_mapel';
    protected $primaryKey = 'kode_mapel';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'kode_mapel', 'nama_mapel', 'alias', 'kurikulum', 'program'
    ];
}
