<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $valid = [
        'username' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Username wajib diisi ya...',
                'min_length' => 'Username terlalu singkat...'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Password wajib diisi ya...',
                'min_length' => 'Password terlalu singkat...'
            ]
        ]
    ];

    public $infovalidate = [
        'judul' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Judul wajib diisi ya...'
            ]
        ],
        'teks' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Silahkan isi pengumuman...'
            ]
        ]
    ];

    public $lembagavalidate = [
        'npsn' => [
            'rules' => 'required|is_unique[hazedu_sp.npsn,{npsn}]',
            'errors' => [
                'required' => 'NPSN wajib diisi ya...',
                'is_unique' => 'NPSN sudah terdaftar!'
            ],
        ],
        'satuanpendidikan' => [
            'rules' => 'required|is_unique[hazedu_sp.sp,npsn,{npsn}]',
            'errors' => [
                'required' => 'Satuan Pendidikan wajib diisi ya...',
                'is_unique' => 'Satuan Pendidikan sudah terdaftar!'
            ],
        ],
        'kepsek' => [
            'rules' => 'required|is_unique[hazedu_sp.kepsek,npsn,{npsn}]',
            'errors' => [
                'required' => 'Nama Kepala Sekolah wajib diisi ya...',
                'is_unique' => 'Nama Kepala Sekolah sudah terdaftar!'
            ],
        ],
        'jenis' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Jenis Satuan Pendidikan harus dipilih...',
            ],
        ],
        'jenjang' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Jenjang Satuan Pendidikan harus dipilih...',
            ],
        ],
        'status' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Status Satuan Pendidikan harus dipilih...',
            ],
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat Satuan Pendidikan wajib diisi ya...',
            ],
        ],
        'provinsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Provinsi harus dipilih...',
            ],
        ],
        'kabupaten' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kabupaten harus dipilih...',
            ],
        ],
        'kecamatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kecamatan harus dipilih...',
            ],
        ],
        'kelurahan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kelurahan harus dipilih...',
            ],
        ],
        'telepon' => [
            'rules' => 'required|is_unique[hazedu_sp.telp,npsn,{npsn}]|min_length[11]',
            'errors' => [
                'required' => 'Nomor Handphone sekolah wajib diisi ya...',
                'is_unique' => 'No. Handphone sekolah sudah terdaftar!',
                'min_length' => 'No. Handphone minimal 11 angka ya...'
            ],
        ],
        'email' => [
            'rules' => 'required|valid_email|is_unique[hazedu_sp.email,npsn,{npsn}]',
            'errors' => [
                'required' => 'Email wajib diisi ya...',
                'valid_email' => 'Format email tidak valid!',
                'is_unique' => 'Email sekolah sudah terdaftar!'
            ],
        ],
        'website' => [
            'rules' => 'required|valid_url_strict[https]|is_unique[hazedu_sp.website,npsn,{npsn}]',
            'errors' => [
                'required' => 'Email wajib diisi ya...',
                'valid_url_strict' => 'Format URL tidak valid!',
                'is_unique' => 'Website sudah terdaftar!'
            ],
        ],
        'namaoperator' => [
            'rules' => 'required|is_unique[hazedu_users.fname,npsn,{npsn}]',
            'errors' => [
                'required' => 'Nama Operator wajib diisi ya...',
                'is_unique' => 'Nama Operator sudah terdaftar!'
            ],
        ],
        'emailoperator' => [
            'rules' => 'required|valid_email|is_unique[hazedu_users.eml,npsn,{npsn}]',
            'errors' => [
                'required' => 'Email Operator wajib diisi ya...',
                'valid_email' => 'Format email tidak valid!',
                'is_unique' => 'Email operator sudah terdaftar!'
            ],
        ],
        'telpoperator' => [
            'rules' => 'required|is_unique[hazedu_users.hp,npsn,{npsn}]|min_length[11]',
            'errors' => [
                'required' => 'Nomor Handphone operator wajib diisi ya...',
                'is_unique' => 'No Handphone operator sudah terdaftar!',
                'min_length' => 'No. Handphone minimal 11 angka ya...'
            ],
        ],
    ];

    public $gtkadmin = [
        'nama' => [
            'rules' => 'required|is_unique[hazedu_gtk.nama,npsn,{npsn}]',
            'errors' => [
                'required' => 'Nama wajib diisi ya...',
                'is_unique' => 'Nama GTK sudah terdaftar!'
            ]
        ],
        'jk' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Jenis kelamin harus dipilih ya...'
            ]
        ],
        'tempatlahir' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tempat lahir wajib diisi ya...'
            ]
        ],
        'tgllahir' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tanggal lahir wajib diisi ya...'
            ]
        ],
        'ibukandung' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ibu kandung wajib diisi ya...'
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat wajib diisi ya...'
            ]
        ],
        'provinsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Provinsi nya ya...'
            ]
        ],
        'kabupaten' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kabupaten juga pilih ya...'
            ]
        ],
        'kecamatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kecamatan juga pilih ya...'
            ]
        ],
        'kelurahan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kelurahan juga pilih ya...'
            ]
        ],
        'agama' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Agama harus dipilih ya...'
            ]
        ],
        'nik' => [
            'rules' => 'required|is_unique[hazedu_gtk.nik,npsn,{npsn}]|min_length[16]',
            'errors' => [
                'required' => 'NIK wajib diisi ya...',
                'is_unique' => 'NIK sudah terdaftar!',
                'min_length' => 'NIK minimal 16 angka ya',
            ]
        ],
        'statusnikah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Status nikah harus dipilih ya...'
            ]
        ],
        'jenisptk' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Jenis PTK harus dipilih ya...'
            ]
        ],
        'statuspegawai' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Status kepegawaian harus dipilih ya...'
            ]
        ],
        'skkerja' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'SK pengangkatan wajib diisi ya...'
            ]
        ],
        'tmtkerja' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'TMT pengangkatan wajib diisi ya...'
            ]
        ],
        'lembagapengangkatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Lembaga pengangkatan harus dipilih ya...'
            ]
        ],
        'sumbergaji' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Sumber gaji harus dipilih ya...'
            ]
        ],
        'handphone' => [
            'rules' => 'required|is_unique[hazedu_gtk.hp,npsn,{npsn}]|min_length[11]',
            'errors' => [
                'required' => 'No. Handphone wajib diisi ya...',
                'is_unique' => 'No. Handphone sudah terdaftar!',
                'min_length' => 'No. Handphone minimal 11 angka ya...',
            ]
        ],
        'email' => [
            'rules' => 'required|is_unique[hazedu_gtk.email,npsn,{npsn}]|valid_email',
            'errors' => [
                'required' => 'Email wajib diisi ya...',
                'is_unique' => 'Email sudah terdaftar!',
                'valid_email' => 'Format Email tidak valid!'
            ]
        ],
    ];

    public $gtkaccountvalidate = [
        'newpassword' => [
            'rules' => 'required|min_length[4]|max_length[8]',
            'errors' => [
                'required' => 'Password wajib diisi ya...',
                'min_length' => 'Passoword minimal 4 karakter',
                'max_length' => 'Passoword minimal 8 karakter',
            ]
        ],
        'repeatpassword' => [
            'rules' => 'required|matches[newpassword]s',
            'errors' => [
                'required' => 'Ulangi Password wajib diisi ya...',
                'matches' => 'Ulangi Password tidak sama dengan password baru'
            ]
        ],
    ];

    public $importvalidate = [
        'file' => [
            'rules' => 'uploaded[file]',
            'errors' => [
                'uploaded' => 'Pilih file yang akan diimport...'
            ]
        ]
    ];

    public $pdvalidatewali = [
        'nama' => [
            'rules' => 'required|is_unique[hazedu_siswa.nama,npsn,{npsn}]',
            'errors' => [
                'required' => 'Nama wajib diisi ya...',
                'is_unique' => 'Nama GTK sudah terdaftar!'
            ]
        ],
        'jk' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Jenis kelamin harus dipilih ya...'
            ]
        ],
        'nisn' => [
            'rules' => 'required|min_length[10]|is_unique[hazedu_siswa.nisn,npsn,{npsn}]',
            'errors' => [
                'required' => 'NISN wajib diisi ya...',
                'min_length' => 'NISN minimal 10 angka ya',
                'is_unique' => 'NISN sudah terdaftar!'
            ]
        ],
        'tempatlahir' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tempat lahir wajib diisi ya...'
            ]
        ],
        'tgllahir' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tanggal lahir wajib diisi ya...'
            ]
        ],
        'ibukandung' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ibu kandung wajib diisi ya...'
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat wajib diisi ya...'
            ]
        ],
        'provinsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Provinsi nya ya...'
            ]
        ],
        'kabupaten' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kabupaten juga pilih ya...'
            ]
        ],
        'kecamatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kecamatan juga pilih ya...'
            ]
        ],
        'kelurahan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kelurahan juga pilih ya...'
            ]
        ],
        'agama' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Agama harus dipilih ya...'
            ]
        ],
        'nik' => [
            'rules' => 'required|is_unique[hazedu_siswa.nik,npsn,{npsn}]|min_length[16]',
            'errors' => [
                'required' => 'NIK wajib diisi ya...',
                'is_unique' => 'NIK sudah terdaftar!',
                'min_length' => 'NIK minimal 16 angka ya',
            ]
        ],
        'jenistinggal' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Piih tempat tinggal nya ya...'
            ]
        ],
        'transportasi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih transportasi yang digunakan ya...'
            ]
        ],
        'namaayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ayah wajib diisi ya...'
            ]
        ],
        'thnayah' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Tahun lahir ayah wajib diisi ya...',
                'min_length' => 'Tahun lahir minimal 4 angka ya...'
            ]
        ],
        'pendidikanayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih pendidikan ayah ya...'
            ]
        ],
        'pekerjaanayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pekerjaan ayah juga dipilih ya...'
            ]
        ],
        'penghasilanayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penghasilan ayah juga dipilih ya...'
            ]
        ],
        'ibukandung' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ibu wajib diisi ya...'
            ]
        ],
        'thnibu' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Tahun lahir ibu wajib diisi ya...',
                'min_length' => 'Tahun lahir minimal 4 angka ya...'
            ]
        ],
        'pendidikanibu' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih pendidikan ibu ya...'
            ]
        ],
        'pekerjaanibu' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pekerjaan ibu juga dipilih ya...'
            ]
        ],
        'penghasilanibu' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penghasilan ibu juga dipilih ya...'
            ]
        ],
        'namawali' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama wali wajib diisi ya...'
            ]
        ],
        'thnwali' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Tahun lahir wali wajib diisi ya...',
                'min_length' => 'Tahun lahir minimal 4 angka ya...'
            ]
        ],
        'pendidikanwali' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih pendidikan wali ya...'
            ]
        ],
        'pekerjaanwali' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pekerjaan wali juga dipilih ya...'
            ]
        ],
        'penghasilanwali' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penghasilan wali juga dipilih ya...'
            ]
        ],
        'handphone' => [
            'rules' => 'required|is_unique[hazedu_siswa.hp,npsn,{npsn}]|min_length[11]',
            'errors' => [
                'required' => 'No. Handphone wajib diisi ya...',
                'is_unique' => 'No. Handphone sudah terdaftar!',
                'min_length' => 'No. Handphone minimal 11 angka',
            ]
        ],
        'email' => [
            'rules' => 'required|is_unique[hazedu_siswa.email,npsn,{npsn}]|valid_email',
            'errors' => [
                'required' => 'Email wajib diisi ya...',
                'is_unique' => 'Email sudah terdaftar!',
                'valid_email' => 'Format Email tidak valid!'
            ]
        ],
    ];

    public $pdvalidatenonwali = [
        'nama' => [
            'rules' => 'required|is_unique[hazedu_siswa.nama,npsn,{npsn}]',
            'errors' => [
                'required' => 'Nama wajib diisi ya...',
                'is_unique' => 'Nama GTK sudah terdaftar!'
            ]
        ],
        'jk' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Jenis kelamin harus dipilih ya...'
            ]
        ],
        'nisn' => [
            'rules' => 'required|min_length[10]|is_unique[hazedu_siswa.nisn,npsn,{npsn}]',
            'errors' => [
                'required' => 'NISN wajib diisi ya...',
                'min_length' => 'NISN minimal 10 angka ya',
                'is_unique' => 'NISN sudah terdaftar!'
            ]
        ],
        'tempatlahir' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tempat lahir wajib diisi ya...'
            ]
        ],
        'tgllahir' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tanggal lahir wajib diisi ya...'
            ]
        ],
        'ibukandung' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ibu kandung wajib diisi ya...'
            ]
        ],
        'alamat' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat wajib diisi ya...'
            ]
        ],
        'provinsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Provinsi nya ya...'
            ]
        ],
        'kabupaten' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kabupaten juga pilih ya...'
            ]
        ],
        'kecamatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kecamatan juga pilih ya...'
            ]
        ],
        'kelurahan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kelurahan juga pilih ya...'
            ]
        ],
        'agama' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Agama harus dipilih ya...'
            ]
        ],
        'nik' => [
            'rules' => 'required|is_unique[hazedu_siswa.nik,npsn,{npsn}]|min_length[16]',
            'errors' => [
                'required' => 'NIK wajib diisi ya...',
                'is_unique' => 'NIK sudah terdaftar!',
                'min_length' => 'NIK minimal 16 angka ya',
            ]
        ],
        'jenistinggal' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Piih tempat tinggal nya ya...'
            ]
        ],
        'transportasi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih transportasi yang digunakan ya...'
            ]
        ],
        'namaayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ayah wajib diisi ya...'
            ]
        ],
        'thnayah' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Tahun lahir ayah wajib diisi ya...',
                'min_length' => 'Tahun lahir minimal 4 angka ya...',
            ]
        ],
        'pendidikanayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih pendidikan ayah ya...'
            ]
        ],
        'pekerjaanayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pekerjaan ayah juga dipilih ya...'
            ]
        ],
        'penghasilanayah' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penghasilan ayah juga dipilih ya...'
            ]
        ],
        'ibukandung' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama ibu wajib diisi ya...'
            ]
        ],
        'thnibu' => [
            'rules' => 'required|min_length[4]',
            'errors' => [
                'required' => 'Tahun lahir ibu wajib diisi ya...',
                'min_length' => 'Tahun lahir minimal 4 angka ya...',
            ]
        ],
        'pendidikanibu' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih pendidikan ibu ya...'
            ]
        ],
        'pekerjaanibu' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pekerjaan ibu juga dipilih ya...'
            ]
        ],
        'penghasilanibu' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Penghasilan ibu juga dipilih ya...'
            ]
        ],
        'handphone' => [
            'rules' => 'required|is_unique[hazedu_siswa.hp,npsn,{npsn}]|min_length[11]',
            'errors' => [
                'required' => 'No. Handphone wajib diisi ya...',
                'is_unique' => 'No. Handphone sudah terdaftar!',
                'min_length' => 'No. Handphone minimal 11 angka',
            ]
        ],
        'email' => [
            'rules' => 'required|is_unique[hazedu_siswa.email,npsn,{npsn}]|valid_email',
            'errors' => [
                'required' => 'Email wajib diisi ya...',
                'is_unique' => 'Email sudah terdaftar!',
                'valid_email' => 'Format Email tidak valid!'
            ]
        ],
    ];

    public $rombelvalidate = [
        'jenjang' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Program Keahlian'
            ]
        ],
        'tingkatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih tingkatan rombel',
            ]
        ],
        'kurikulum' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih kurikulum pembelajaran'
            ]
        ],
        'namarombel' => [
            'rules' => 'required|is_unique[hazedu_rombel.nama,npsn,npsn]',
            'errors' => [
                'required' => 'Masukkan nama rombongan belajar',
                'is_unique' => 'Rombel {value} sudah ada!'
            ]
        ],
        'walikelas' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Wali Kelas wajib dipilih'
            ]
        ],
        'ruang' => [
            'rules' => 'required|is_unique[hazedu_rombel.ruang,npsn,npsn]',
            'errors' => [
                'required' => 'Masukkan nama ruang untuk rombel',
                'is_unique' => 'Nama {value} sudah ada!'
            ]
        ],
    ];

    public $banksoalvalidate = [
        'jenjang' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Jenjang Pendidikan'
            ]
        ],
        'tingkatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Tingkatan Pendidikan'
            ]
        ],
        'mapel' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Mata Pelajaran'
            ]
        ],
        'soalpg' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan Jumlah Soal PG'
            ]
        ],
        'bobotpg' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan Bobot Soal PG'
            ]
        ],
        'opsi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Opsi Jawaban'
            ]
        ],
        'soalesai' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan Jumlah Soal Essay'
            ]
        ],
        'bobotesai' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan Bobot Soal Essay'
            ]
        ],
        'paketsoal' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Paket Soal Ujian'
            ]
        ],
        'guru' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih Guru Mata Pelajaran'
            ]
        ],
        'status' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan Status Soal'
            ]
        ],
    ];

    public $jadwalvalidate = [
        'jenjang' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih {field} pendidikan'
            ]
        ],
        'tingkatan' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih {field}'
            ]
        ],
        // 'romble' => [
        //     'rules' => 'required',
        //     'errors' => [
        //         'required' => 'Pilih rombongan belajar'
        //     ]
        // ],
        'mapel' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Silahkan pilih mapel dari bank soal'
            ]
        ],
        'jenisujian' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih jenis ujiannya'
            ]
        ],
        'sesi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Pilih {field} ujian'
            ]
        ],
        'tglujian' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan tanggal mulai ujian'
            ]
        ],
        'timer' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan jam mulai ujian'
            ]
        ],
        'tglexpired' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan masa berlaku jadwal ujian'
            ]
        ],
        'durasi' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan lama waktu ujian'
            ]
        ],
        'kkm' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Tentukan nilai Kriteria Ketuntasan Minimum'
            ]
        ],
    ];
}
