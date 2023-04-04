<?php

namespace App\Models;

use CodeIgniter\Model;

class GtkModel extends Model
{
    protected $table      = 'hazedu_gtk';
    protected $primaryKey = 'uid_gtk';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'uid_gtk', 'npsn', 'nik', 'kewarganegaraan', 'nama', 'nuptk', 'jk', 'tempatlahir', 'tgllahir', 'nip', 'status_gtk', 'jenis_ptk', 'agama', 'alamat', 'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan', 'kodepos', 'telepon', 'hp', 'email', 'tugastambahan', 'sk_kerja', 'tmt_kerja', 'lembagapengangkatan', 'sumbergaji', 'namaibu', 'statuskawin', 'foto'
    ];
}
