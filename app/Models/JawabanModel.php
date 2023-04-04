<?php

namespace App\Models;

use CodeIgniter\Model;

class JawabanModel extends Model
{
    protected $table      = 'hazedu_soal_jawaban';
    protected $primaryKey = 'uid_jawaban';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'uid_jawaban', 'uid_banksoal', 'uid_soal', 'npsn', 'soal_tipe', 'nomor', 'detail_opsi', 'jawaban', 'kunci_jwbn', 'status'
    ];

    protected $useTimestamps = false;
}
