<?php

namespace App\Models;

use CodeIgniter\Model;

class LembagaModel extends Model
{
    protected $table      = 'hazedu_sp';
    protected $primaryKey = 'uid_sp';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = ['uid_sp', 'npsn', 'sp', 'jenis', 'status', 'jenjang', 'kepsek', 'nip', 'alamat', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'telp', 'email', 'website', 'logo', 'regis_date', 'is_activated', 'activation_date'];
}
