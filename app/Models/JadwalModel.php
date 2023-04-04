<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table      = 'hazedu_jadwal';
    protected $primaryKey = 'uid_jadwal';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['uid_jadwal', 'npsn', 'uid_banksoal', 'kode_ujian', 'gtk', 'mapel', 'kategori', 'jenjang', 'jurusan', 'tingkatan', 'rombel', 'sesi', 'acak', 'token', 'status', 'jml_pg', 'bobot_pg', 'opsi', 'jml_esai', 'bobot_esai', 'kkm', 'durasi_ujian', 'tgl_ujian', 'jam_ujian', 'tgl_expired', 'waktu_mulai', 'waktu_selesai'];
}
