<?php

namespace App\Models;

use CodeIgniter\Model;

class SoalModel extends Model
{
    protected $table      = 'soal';
    protected $primaryKey = 'uid_soal';
    protected $useAutoIncrement = false;

    protected $allowedFields = [
        'uid_soal', 'npsn', 'uid_banksoal', 'kode_mapel', 'mapel', 'alias', 'kategori', 'gtk', 'nomor', 'soal', 'jenis', 'pilA', 'pilB', 'pilC', 'pilD', 'pilE', 'jawaban', 'jawaban_essay', 'file_audio', 'fileA', 'fileB', 'fileC', 'fileD', 'fileE', 'paket_soal', 'jenjang', 'jurusan', 'tingkatan', 'rombel', 'created_time', 'updated_time'
    ];

    protected $useTimestamps = false;
}
