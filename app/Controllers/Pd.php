<?php

namespace App\Controllers;

class Pd extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Peserta Didik',
            'titlecontent' => 'Peserta Didik',
            'breadcrumb' => 'Peserta Didik',
            'setting' => $this->apps->first(),
            'datasiswa' => $this->pd->findAll(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'satuanpendidikan' => (session()->lv == 1) ? $this->sp->orderBy('sp', 'ASC')->findAll() : $this->sp->where('npsn', session()->npsn)->find(),
            'resultAgama' => $this->db->table('hazedu_agama')->orderBy('agama', 'ASC')->get()->getResultArray(),
            'provinsi' => $this->provinsi->orderBy('name', 'ASC')->findAll(),
            'dataagama' => $this->db->table('hazedu_agama')->get()->getResultArray(),
            'datatinggal' => $this->db->table('jenis_tinggal')->orderBy('id', 'ASC')->get()->getResultArray(),
            'datatransportasi' => $this->db->table('transportasi')->orderBy('id', 'ASC')->get()->getResultArray(),
            'datapekerjaan' => $this->db->table('pekerjaan')->orderBy('id', 'ASC')->get()->getResultArray(),
            'datapendidikan' => $this->db->table('pendidikan')->orderBy('id', 'ASC')->get()->getResultArray(),
            'datapenghasilan' => $this->db->table('penghasilan')->orderBy('id', 'ASC')->get()->getResultArray(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Peserta Didik'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('pdidik', $data);
    }

    public function viewdata()
    {
        $dtpost = $this->request->getVar();
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowPerPage = $dtpost['length'];
        $columnIndex = $dtpost['order'][0]['column'];
        $searchValue = $dtpost['search']['value'];

        if (isset($searchValue)) {
            $search = 'npsn = "' . session()->npsn . '" AND (
                nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->pd->where('nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"')->countAllResults() : $this->pd->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->pd->where('nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"')->countAllResults() : $this->pd->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->pd->where($search)->orderBy('nama', 'ASC')->findAll() : $this->pd->where('nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"')->orderBy('nama', 'ASC')
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->pd->where($search)->orderBy('nama', 'ASC')->findAll($rowPerPage, $start) : $this->pd->where('nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"')
                ->orderBy('nama', 'ASC')
                ->findAll($rowPerPage, $start);
        }

        $akses = $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Peserta Didik'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = $no;
            $data[] = '<a href="' . $explode[0] . 'details/' . $key['uid_siswa'] . '">' . $key['nama'] . '</a>';
            $data[] = $key['jk'];
            $data[] = ($key['nisn'] == '') ? '-' : $key['nisn'];
            $data[] = ($key['tingkatan'] == '') ? '-' : $key['tingkatan'];
            $data[] = ($key['rombel'] == '') ? '-' : $key['rombel'];

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary btn-edit mr-1 px-2" data-id="' . $key['uid_siswa'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_siswa'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_siswa'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary btn-edit px-2" data-id="' . $key['uid_siswa'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_siswa'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_siswa'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else {
                $data[] = '';
            }

            $array[] = $data;
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRows,
            'iTotalDisplayRecords' => $totalRowsWithFilter,
            'data' => $array,

        ];

        return $this->response->setJSON($response);
    }

    public function save()
    {
        $data = $this->request->getPost();
        if ($data['wali'] == 'Ya') {
            $validate = $this->validation->run($data, 'pdvalidatewali');
        } else {
            $validate = $this->validation->run($data, 'pdvalidatenonwali');
        }
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $acak = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            $pd = new \CodeIgniter\Entity\Entity();
            $pd->fill($data);
            $pd->uid_siswa = 'PD-' . $data['satuanpendidikan'] . '-' . substr(str_shuffle($acak), 0, 6);
            $pd->npsn = $data['satuanpendidikan'];
            $pd->tempat_lahir = $data['tempatlahir'];
            $pd->tanggal_lahir = $data['tgllahir'];
            $pd->kode_pos = $data['kodepos'];
            $pd->jenis_tinggal = $data['jenistinggal'];
            $pd->alat_transportasi = $data['transportasi'];
            $pd->nama_ayah = $data['namaayah'];
            $pd->tahun_ayah = $data['thnayah'];
            $pd->pendidikan_ayah = $data['pendidikanayah'];
            $pd->pekerjaan_ayah = $data['pekerjaanayah'];
            $pd->penghasilan_ayah = $data['penghasilanayah'];
            $pd->nama_ibu = $data['ibukandung'];
            $pd->tahun_ibu = $data['thnibu'];
            $pd->pendidikan_ibu = $data['pendidikanibu'];
            $pd->pekerjaan_ibu = $data['pekerjaanibu'];
            $pd->penghasilan_ibu = $data['penghasilanibu'];

            if ($data['wali'] == 'Ya') {
                $pd->nama_wali = $data['namawali'];
                $pd->tahun_wali = $data['thnwali'];
                $pd->pendidikan_wali = $data['pendidikanwali'];
                $pd->pekerjaan_wali = $data['pekerjaanwali'];
                $pd->penghasilan_wali = $data['penghasilanwali'];
            }

            $pd->telepon = $data['notelp'];
            $pd->hp = $data['handphone'];

            if ($this->pd->insert($pd)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
            }
        }
    }

    public function edit($id = null, $action = null)
    {
        if ($id) {
            $query = $this->pd->where('uid_siswa', $id)->first();
            $datakelurahan = $this->kelurahan->where('name', $query['kelurahan'])->first();
            $datakecamatan = $this->kecamatan->where('id', $datakelurahan['district_id'])->first();
            $datakabupaten = $this->kabupaten->where('id', $datakecamatan['regency_id'])->first();
            $dataprovinsi = $this->provinsi->where('id', $datakabupaten['province_id'])->first();

            if ($action == '') {
                return $this->response->setJSON([
                    "title" => 'Edit Peserta Didik',
                    'npsn' => $query['npsn'],
                    'nama' => $query['nama'],
                    'kelamin' => $query['jk'],
                    'nisn' => $query['nisn'],
                    'warganegara' => $query['warganegara'],
                    'nik' => $query['nik'],
                    'tempatlahir' => $query['tempat_lahir'],
                    'tgllahir' => $query['tanggal_lahir'],
                    'agama' => $query['agama'],
                    'alamat' => $query['alamat'],
                    'rt' => $query['rt'],
                    'rw' => $query['rw'],
                    'provinsi' => $dataprovinsi['name'],
                    'kabupaten' => $datakabupaten['name'],
                    'kecamatan' => $datakecamatan['name'],
                    'kelurahan' => $datakelurahan['name'],
                    'dusun' => $query['dusun'],
                    'kodepos' => $query['kode_pos'],
                    'jenistinggal' => $query['jenis_tinggal'],
                    'transportasi' => $query['alat_transportasi'],
                    'namaayah' => $query['nama_ayah'],
                    'thnayah' => $query['tahun_ayah'],
                    'pendidikanayah' => $query['pendidikan_ayah'],
                    'pekerjaanayah' => $query['pekerjaan_ayah'],
                    'penghasilanayah' => $query['penghasilan_ayah'],
                    'ibukandung' => $query['nama_ibu'],
                    'thnibu' => $query['tahun_ibu'],
                    'pendidikanibu' => $query['pendidikan_ibu'],
                    'pekerjaanibu' => $query['pekerjaan_ibu'],
                    'penghasilanibu' => $query['penghasilan_ibu'],
                    'wali' => ($query['nama_wali'] == '') ? 'Tidak' : 'Ya',
                    'namawali' => ($query['nama_wali'] == '') ? 'Tidak' : $query['nama_wali'],
                    'thnwali' => $query['tahun_wali'],
                    'pendidikanwali' => $query['pendidikan_wali'],
                    'pekerjaanwali' => $query['pekerjaan_wali'],
                    'penghasilanwali' => $query['penghasilan_wali'],
                    'notelp' => $query['telepon'],
                    'handphone' => $query['hp'],
                    'email' => $query['email'],
                    'action' => '/pd/edit/' . $id . '/save',
                ]);
            } else if ($action == 'save') {
                $data = $this->request->getPost();
                $validate = $this->validate([
                    'nama' => [
                        'rules' => ($data['nama'] == $query['nama']) ? 'required' : 'required|is_unique[hazedu_siswa.nama,npsn,{npsn}]',
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
                        'rules' => ($data['nisn'] == $query['nisn']) ? 'required' : 'required|min_length[10]|is_unique[hazedu_siswa.nisn,npsn,{npsn}]',
                        'errors' => [
                            'required' => 'NISN wajib diisi ya...',
                            'min_length' => 'NISN minimal 10 angka ya',
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
                        'rules' => ($data['nik'] == $query['nik']) ? 'required' : 'required|is_unique[hazedu_siswa.nik,npsn,{npsn}]|min_length[16]',
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
                        'rules' => ($data['handphone'] == $query['hp']) ? 'required' : 'required|is_unique[hazedu_siswa.hp,npsn,{npsn}]|min_length[11]',
                        'errors' => [
                            'required' => 'No. Handphone wajib diisi ya...',
                            'is_unique' => 'No. Handphone sudah terdaftar!',
                            'min_length' => 'No. Handphone minimal 11 angka',
                        ]
                    ],
                    'email' => [
                        'rules' => ($data['email'] == $query['email']) ? 'required' : 'required|is_unique[hazedu_siswa.email,npsn,{npsn}]|valid_email',
                        'errors' => [
                            'required' => 'Email wajib diisi ya...',
                            'is_unique' => 'Email sudah terdaftar!',
                            'valid_email' => 'Format Email tidak valid!'
                        ]
                    ],
                ]);

                if ($data['wali'] == 'Ya') {
                    $validate .= $this->validate([
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
                                'min_length' => 'Tahun lahir minimal 4 angka ya...',
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
                    ]);
                }

                $errors = $this->validation->getErrors();

                if ($errors) {
                    return $this->response->setJSON($errors)->setStatusCode(404);
                } else {
                    $pd = new \CodeIgniter\Entity\Entity();
                    $pd->fill($data);
                    $pd->tempat_lahir = $data['tempatlahir'];
                    $pd->tanggal_lahir = $data['tgllahir'];
                    $pd->kode_pos = $data['kodepos'];
                    $pd->jenis_tinggal = $data['jenistinggal'];
                    $pd->alat_transportasi = $data['transportasi'];
                    $pd->nama_ayah = $data['namaayah'];
                    $pd->tahun_ayah = $data['thnayah'];
                    $pd->pendidikan_ayah = $data['pendidikanayah'];
                    $pd->pekerjaan_ayah = $data['pekerjaanayah'];
                    $pd->penghasilan_ayah = $data['penghasilanayah'];
                    $pd->nama_ibu = $data['ibukandung'];
                    $pd->tahun_ibu = $data['thnibu'];
                    $pd->pendidikan_ibu = $data['pendidikanibu'];
                    $pd->pekerjaan_ibu = $data['pekerjaanibu'];
                    $pd->penghasilan_ibu = $data['penghasilanibu'];

                    if ($data['wali'] == 'Ya') {
                        $pd->nama_wali = $data['namawali'];
                        $pd->tahun_wali = $data['thnwali'];
                        $pd->pendidikan_wali = $data['pendidikanwali'];
                        $pd->pekerjaan_wali = $data['pekerjaanwali'];
                        $pd->penghasilan_wali = $data['penghasilanwali'];
                    }

                    $pd->telepon = $data['notelp'];
                    $pd->hp = $data['handphone'];

                    if ($this->pd->update($id, $pd)) {
                        return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                    } else {
                        return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
                    }
                }
            }
        } else {
            return redirect()->to('/pd');
        }
    }

    public function delete($id)
    {
        if ($this->pd->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus...']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!'])->setStatusCode(400);
        }
    }
}
