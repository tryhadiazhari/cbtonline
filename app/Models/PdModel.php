<?php

namespace App\Models;

use CodeIgniter\Model;

class PdModel extends Model
{
    protected $table      = 'hazedu_siswa';
    protected $primaryKey = 'uid_siswa';
    protected $useTimestamps = false;
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'uid_siswa', 'npsn', 'nama', 'nis', 'jk', 'nisn', 'warganegara', 'nik', 'tempat_lahir', 'tanggal_lahir', 'agama', 'alamat', 'rt', 'rw', 'dusun', 'kelurahan', 'kecamatan', 'kode_pos', 'jenis_tinggal', 'alat_transportasi', 'telepon', 'hp', 'email', 'nama_ayah', 'tahun_ayah', 'pendidikan_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nama_ibu', 'tahun_ibu', 'pendidikan_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'nama_wali', 'tahun_wali', 'pendidikan_wali', 'pekerjaan_wali', 'penghasilan_wali', 'kebutuhan_khusus', 'rombel', 'tingkatan', 'jenis_daftar', 'no_peserta', 'uname', 'pword', 'sesi', 'foto', 'date_created', 'date_update'
    ];
}
