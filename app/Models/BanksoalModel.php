<?php

namespace App\Models;

use CodeIgniter\Model;

class BanksoalModel extends Model
{
    protected $table      = 'hazedu_banksoal';
    protected $primaryKey = 'uid_banksoal';
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'uid_banksoal', 'npsn', 'kode_mapel', 'mapel', 'alias', 'kategori', 'gtk', 'jenjang', 'jurusan', 'tingkatan', 'rombel', 'jml_pg', 'tampil_pg', 'bobot_pg', 'jml_esai', 'tampil_esai', 'bobot_esai', 'opsi', 'paket_soal', 'status', 'file', 'created_date', 'update_date'
    ];

    protected $useTimestamps = false;
}
