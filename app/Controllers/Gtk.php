<?php

namespace App\Controllers;

class Gtk extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Data Guru',
            'titlecontent' => 'Data Guru',
            'setting' => $this->apps->first(),
            'satuanpendidikan' => (session()->lv == 1) ? $this->sp->orderBy('sp', 'ASC')->findAll() : $this->sp->where('npsn', session()->npsn)->find(),
            'provinsi' => $this->provinsi->orderBy('name', 'ASC')->findAll(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'dataagama' => $this->db->table('hazedu_agama')->get()->getResultArray(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'GTK'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('gtk', $data);
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
                npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"
                OR tempatlahir LIKE "%' . $searchValue . '%"
                OR tgllahir LIKE "%' . $searchValue . '%"
                OR jenis_ptk LIKE "%' . $searchValue . '%"
                OR email LIKE "%' . $searchValue . '%"
                OR nuptk LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->gtk->where('npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"
                OR tempatlahir LIKE "%' . $searchValue . '%"
                OR tgllahir LIKE "%' . $searchValue . '%"
                OR jenis_ptk LIKE "%' . $searchValue . '%"
                OR email LIKE "%' . $searchValue . '%"
                OR nuptk LIKE "%' . $searchValue . '%"')->countAllResults() : $this->gtk->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->gtk->where('npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"
                OR tempatlahir LIKE "%' . $searchValue . '%"
                OR tgllahir LIKE "%' . $searchValue . '%"
                OR jenis_ptk LIKE "%' . $searchValue . '%"
                OR email LIKE "%' . $searchValue . '%"
                OR nuptk LIKE "%' . $searchValue . '%"')->countAllResults() : $this->gtk->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->gtk->where($search)->orderBy('nama', 'ASC')->findAll() : $this->gtk->where('npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"
                OR tempatlahir LIKE "%' . $searchValue . '%"
                OR tgllahir LIKE "%' . $searchValue . '%"
                OR jenis_ptk LIKE "%' . $searchValue . '%"
                OR email LIKE "%' . $searchValue . '%"
                OR nuptk LIKE "%' . $searchValue . '%"')->orderBy('nama', 'ASC')
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->gtk->where($search)->orderBy('nama', 'ASC')->findAll($rowPerPage, $start) : $this->gtk->where('npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"
                OR tempatlahir LIKE "%' . $searchValue . '%"
                OR tgllahir LIKE "%' . $searchValue . '%"
                OR jenis_ptk LIKE "%' . $searchValue . '%"
                OR email LIKE "%' . $searchValue . '%"
                OR nuptk LIKE "%' . $searchValue . '%"')
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
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'GTK'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = $no;
            $data[] = '<a href="' . $explode[0] . 'details/' . $key['uid_gtk'] . '">' . $key['nama'] . '</a>';
            $data[] = $key['tempatlahir'] . ', ' . $key['tgllahir'];
            $data[] = $key['jenis_ptk'];
            $data[] = $key['email'];
            $data[] = $key['nuptk'];

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary btn-edit mr-1 px-2" data-id="' . $key['uid_gtk'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_gtk'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_gtk'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary btn-edit px-2" data-id="' . $key['uid_gtk'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_gtk'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_gtk'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
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
        $validate = $this->validation->run($data, 'gtkadmin');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $acak = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

            $gtk = new \CodeIgniter\Entity\Entity();
            $gtk->fill($data);
            $gtk->uid_gtk = substr('GTK-' . str_shuffle($acak), 0, 50);
            $gtk->npsn = $data['satuanpendidikan'];
            $gtk->kewarganegaraan = $data['warganegara'];
            $gtk->status_gtk = $data['statuspegawai'];
            $gtk->jenis_ptk = $data['jenisptk'];
            $gtk->telepon = $data['notelp'];
            $gtk->hp = $data['handphone'];
            $gtk->tugastambahan = '';
            $gtk->sk_kerja = $data['skkerja'];
            $gtk->tmt_kerja = $data['tmtkerja'];
            $gtk->namaibu = $data['ibukandung'];
            $gtk->statuskawin = $data['statusnikah'];
            $gtk->foto = '';

            $acak = substr(str_shuffle($acak), 0, 8);

            $user = new \CodeIgniter\Entity\Entity();
            $user->fill($data);
            $user->uid = $gtk->uid_gtk;
            $user->npsn = $data['satuanpendidikan'];
            $user->fname = $data['nama'];
            $user->eml = $data['email'];
            $user->hp = $data['handphone'];
            $user->uname = $data['satuanpendidikan'] . '_' . substr(str_shuffle($acak), 0, 6);
            $user->pword = password_hash($acak, PASSWORD_DEFAULT);
            $user->lv = 3;
            $user->is_activated = 1;
            $user->activation_date = date('Y-m-d H:i:s');

            if (count($this->login->where('uname', $user->uname)->find()) == 0) {
                $this->email->setFrom('noreply@hazwebdevelopment.com', 'HAZ Educa');
                $this->email->setTo($data['email']);
                $this->email->setSubject('HAZ Educa Account');
                $this->email->setMessage(
                    'Hai <b>' . $data['nama'] . '</b>, selamat bergabung di aplikasi HAZ Educa. 
                    <p>Silahkan klik <a href="' . base_url() . '/auth/"><strong>disini</strong></a> untuk akses login Kamu ya...</p>

                    <p>
                        Berikut informasi akses login Anda ke sistem HAZ Educa ya:
                        <table style="padding: 0; margin: 0">
                            <thead>
                                <tr>
                                    <th align="left" width="10%">URL Login</th>
                                    <th align="left" width="1%">:</th>
                                    <th align="left">https://cbt.hazwebdevelopment.com</th>
                                </tr>
                                <tr>
                                    <th align="left">Username</th>
                                    <th align="left" width="1%">:</th>
                                    <th align="left">' . $user->uname . '</th>
                                </tr>
                                <tr>
                                    <th align="left">Password</th>
                                    <th align="left" width="1%">:</th>
                                    <th align="left">' . $acak . '</th>
                                </tr>
                            </thead>
                        </table>
                    </p>
                    <hr />
                    <p class="mt-5">
                        Hormat Kami,<br />
                        <strong>Tim Support HAZ Development</strong>
                    </p>'
                );

                if (!$this->email->send()) {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan, silahkan coba kembali...'])->setStatusCode(400);
                } else {
                    if ($this->gtk->insert($gtk) && $this->login->insert($user)) {
                        return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                    } else {
                        return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
                    }
                }
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
            }
        }
    }

    public function edit($id = null)
    {
        if ($id) {
            $query = $this->gtk->where('uid_gtk', $id)->first();
            $datakecamatan = $this->kecamatan->where('name', $query['kecamatan'])->first();
            $datakabupaten = $this->kabupaten->where('id', $datakecamatan['regency_id'])->first();
            $dataprovinsi = $this->provinsi->where('id', $datakabupaten['province_id'])->first();

            return $this->response->setJSON([
                'npsn' => $query['npsn'],
                'nik' => $query['nik'],
                'warganegara' => $query['kewarganegaraan'],
                'nama' => $query['nama'],
                'nuptk' => $query['nuptk'],
                'kelamin' => $query['jk'],
                'tempatlahir' => $query['tempatlahir'],
                'tgllahir' => $query['tgllahir'],
                'statuspegawai' => $query['status_gtk'],
                'jenisptk' => $query['jenis_ptk'],
                'agama' => $query['agama'],
                'alamat' => $query['alamat'],
                'rt' => $query['rt'],
                'rw' => $query['rw'],
                'dusun' => $query['dusun'],
                'kelurahan' => $query['kelurahan'],
                'kecamatan' => $query['kecamatan'],
                'kabupaten' => $datakabupaten['name'],
                'provinsi' => $dataprovinsi['name'],
                'kodepos' => $query['kodepos'],
                'telepon' => $query['telepon'],
                'handphone' => $query['hp'],
                'email' => $query['email'],
                'skkerja' => $query['sk_kerja'],
                'tmtkerja' => $query['tmt_kerja'],
                'lembagapengangkatan' => $query['lembagapengangkatan'],
                'sumbergaji' => $query['sumbergaji'],
                'ibukandung' => $query['namaibu'],
                'statusnikah' => $query['statuskawin'],
                'foto' => $query['foto'],
                'action' => '/gtk/update/' . $id,
            ]);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id)
    {
        $query = $this->gtk->where('uid_gtk', $id)->first();
        $data = $this->request->getPost();
        $validate = $this->validate([
            'nama' => [
                'rules' => ($data['nama'] == $query['nama']) ? 'required' : 'required|is_unique[hazedu_gtk.nama,npsn,{npsn}]',
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
                'rules' => ($data['nik'] == $query['nik']) ? 'required' : 'required|is_unique[hazedu_gtk.nik,npsn,{npsn}]|min_length[16]',
                'errors' => [
                    'required' => 'NIK harus dipilih ya...',
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
                'rules' => ($data['handphone'] == $query['hp']) ? 'required' : 'required|is_unique[hazedu_gtk.hp,npsn,{npsn}]|min_length[11]',
                'errors' => [
                    'required' => 'No. Handphone wajib diisi ya...',
                    'is_unique' => 'No. Handphone sudah terdaftar...',
                    'min_length' => 'No. Handphone minimal 11 angka ya...',
                ]
            ],
            'email' => [
                'rules' => ($data['email'] == $query['email']) ? 'required' : 'required|is_unique[hazedu_gtk.email,npsn,{npsn}]|valid_email',
                'errors' => [
                    'required' => 'Email wajib diisi ya...',
                    'is_unique' => 'Email sudah terdaftar!',
                    'valid_email' => 'Format Email tidak valid!'
                ]
            ],
        ]);
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $gtk = new \CodeIgniter\Entity\Entity();
            $gtk->fill($data);
            $gtk->npsn = $data['satuanpendidikan'];
            $gtk->kewarganegaraan = $data['warganegara'];
            $gtk->status_gtk = $data['statuspegawai'];
            $gtk->jenis_ptk = $data['jenisptk'];
            $gtk->telepon = $data['notelp'];
            $gtk->hp = $data['handphone'];
            $gtk->tugastambahan = '';
            $gtk->sk_kerja = $data['skkerja'];
            $gtk->tmt_kerja = $data['tmtkerja'];
            $gtk->namaibu = $data['ibukandung'];
            $gtk->statuskawin = $data['statusnikah'];
            $gtk->foto = '';

            if ($this->gtk->update($id, $gtk)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
            }
        }
    }

    public function details($id)
    {
        $query = $this->gtk->find($id);

        $data = [
            'title' => 'Detail Guru',
            'titlecontent' => 'Detail Guru',
            'setting' => $this->apps->first(),
            'datagtk' => $query,
            'satuanpendidikan' => $this->sp->where('npsn', $query['npsn'])->first(),
            'datalembaga' => $this->sp->where('npsn', $query['npsn'])->first(),
            'akun' => $this->login->where('npsn', $query['npsn'])->first(),
        ];

        return view('gtk/details', $data);
    }

    public function account($id)
    {
        $query = $this->login->find($id);
        $data = $this->request->getPost();

        $validate = $this->validation->run($data, 'gtkaccountvalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $user = new \CodeIgniter\Entity\Entity();
            $user->fill($data);
            $user->pword = password_hash($data['newpassword'], PASSWORD_DEFAULT);
            $user->upddate = date('Y-m-d H:i:s');

            $this->email->setFrom('noreply@hazwebdevelopment.com', 'HAZ Educa');
            $this->email->setTo($query['eml']);
            $this->email->setSubject('Change Password');
            $this->email->setMessage(
                'Hai <b>' . $query['fname'] . '</b>, password Kamu sudah diganti ya... 
                    <p>Silahkan klik <a href="' . base_url() . '/auth/"><strong>disini</strong></a> untuk akses login Kamu ya...</p>
                            
                    <p>
                        Berikut informasi akses login Anda ke sistem HAZ Educa ya:
                        <table style="padding: 0; margin: 0">
                            <thead>
                                <tr>
                                    <th align="left" width="10%">URL Login</th>
                                    <th align="left" width="1%">:</th>
                                    <th align="left">https://cbt.hazwebdevelopment.com</th>
                                </tr>
                                <tr>
                                    <th align="left">Username</th>
                                    <th align="left" width="1%">:</th>
                                    <th align="left">' . $query['uname'] . '</th>
                                </tr>
                                <tr>
                                    <th align="left">Password</th>
                                    <th align="left" width="1%">:</th>
                                    <th align="left">' . $data['newpassword'] . '</th>
                                </tr>
                            </thead>
                        </table>
                    </p>
                    <hr />
                    <p class="mt-5">
                        Hormat Kami,<br />
                        <strong>Tim Support HAZ Development</strong>
                    </p>'
            );

            if (!$this->email->send()) {
                return $this->response->setJSON(['error' => 'Email gagal dikirimkan!'])->setStatusCode(400);
            } else {
                if ($this->login->update($id, $user)) {
                    return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                } else {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
                }
            }
        }
    }

    public function import()
    {
        $data = $this->request->getPost('file');
        $validate = $this->validation->run($data, 'importvalidate');
        $error = $this->validation->getError();

        if ($error) {
            return $this->response->setJSON($error)->setStatusCode(404);
        }
    }
    public function delete($id)
    {
        if ($this->gtk->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!!!'])->setStatusCode(400);
        }
    }
}
