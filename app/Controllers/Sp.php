<?php

namespace App\Controllers;

class SP extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Satuan Pendidikan',
            'titlecontent' => 'Satuan Pendidikan',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'provinsi' => $this->provinsi->orderBy('name', 'ASC')->findAll(),
            'datajenjang' => $this->pendidikan->orderBy('uid_jenjang', 'ASC')->findAll(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.import
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Satuan Pendidikan'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('lembaga', $data);
    }

    public function dataview()
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
                OR sp LIKE "%' . $searchValue . '%"
                OR alamat LIKE "%' . $searchValue . '%"
                OR kepsek LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->sp->where('npsn LIKE "%' . $searchValue . '%" 
                OR sp LIKE "%' . $searchValue . '%"
                OR alamat LIKE "%' . $searchValue . '%"
                OR kepsek LIKE "%' . $searchValue . '%"')->countAllResults() : $this->sp->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->sp->where('npsn LIKE "%' . $searchValue . '%" 
                OR sp LIKE "%' . $searchValue . '%"
                OR alamat LIKE "%' . $searchValue . '%"
                OR kepsek LIKE "%' . $searchValue . '%"')->countAllResults() : $this->sp->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->sp->where($search)->orderBy('sp', 'ASC')->findAll() : $this->sp->where('npsn LIKE "%' . $searchValue . '%" 
                OR sp LIKE "%' . $searchValue . '%"
                OR alamat LIKE "%' . $searchValue . '%"
                OR kepsek LIKE "%' . $searchValue . '%"')->orderBy('sp', 'ASC')
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->sp->where($search)->orderBy('sp', 'ASC')->findAll($rowPerPage, $start) : $this->sp->where('npsn LIKE "%' . $searchValue . '%" 
                OR sp LIKE "%' . $searchValue . '%"
                OR alamat LIKE "%' . $searchValue . '%"
                OR kepsek LIKE "%' . $searchValue . '%"')
                ->orderBy('sp', 'ASC')
                ->findAll($rowPerPage, $start);
        }

        $akses = $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.import 
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Satuan Pendidikan'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('dataview', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = $no;
            $data[] = '<a href="' . $explode[0] . 'details/' . $key['uid_sp'] . '">' . $key['npsn'] . '</a>';
            $data[] = '<a href="' . $explode[0] . 'details/' . $key['uid_sp'] . '">' . $key['sp'] . '</a>';
            $data[] = $key['alamat'];
            $data[] = $key['kepsek'];
            $data[] = ($key['is_activated'] == 1) ? '<div class="text-center"><i class="text-success text-center fas fa-check" title="Aktif"></i></div>' : '<div class="text-center"><i class="text-red text-center fas fa-times" title="Belum Aktif"></i></div>';

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary btn-edit mx-1 px-2" data-id="' . $key['uid_sp'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_sp'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger btn-delete mx-1 px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_sp'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary btn-edit px-2" data-id="' . $key['uid_sp'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_sp'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_sp'] . '"><i class="fa fa-trash fa-sm"></i></button>
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
        $validate = $this->validation->run($data, 'lembagavalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $acak = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $entiti = new \CodeIgniter\Entity\Entity();
            $entiti->fill($data);
            $entiti->uid_sp = ($data['jenis'] == 'Pendidikan Kesetaraan') ? substr('PKBM-' . str_shuffle($acak), 0, 50) : substr($data['npsn'] . '-' . str_shuffle($acak), 0, 50);
            $entiti->sp = $data['satuanpendidikan'];
            $entiti->telp = $data['telepon'];
            $entiti->jenjang = '';

            foreach ($data['jenjang'] as $input_val) {
                $entiti->jenjang .= $input_val . ', ';
            }

            $entiti->jenjang = substr($entiti->jenjang, 0, -2);

            $token = password_hash($data['npsn'], PASSWORD_DEFAULT);

            $this->email->setFrom('noreply@hazwebdevelopment.com', 'HAz Educa');
            $this->email->setTo($data['emailoperator']);
            $this->email->setSubject('Account Activation HAZ Educa');
            $this->email->setMessage(
                'Hai operator <b>' . $data['satuanpendidikan'] . '</b>, selamat bergabung di aplikasi HAz Educa. 
                <p>Silahkan klik <a href="' . base_url() . '/auth/verification?token=' . urlencode($token) . '"><strong>disini</strong></a> untuk aktifasi akun Anda</p>
                
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
                                <th align="left">' . $data['npsn'] . '</th>
                            </tr>
                            <tr>
                                <th align="left">Password</th>
                                <th align="left" width="1%">:</th>
                                <th align="left">' . $data['npsn'] . '</th>
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
                $insertUserToken = $this->db->table('hazedu_users_token')->insert([
                    'username' => $data['npsn'],
                    'email' => $data['emailoperator'],
                    'token' => $token,
                ]);

                if ($this->sp->insert($entiti)) {
                    $users = new \CodeIgniter\Entity\Entity();
                    $users->fill($data);
                    $users->uid = substr($data['npsn'] . '-' . str_shuffle($acak), 0, 10) . time();
                    $users->fname = $data['namaoperator'];
                    $users->eml = $data['emailoperator'];
                    $users->hp = $data['telpoperator'];
                    $users->uname = $data['npsn'];
                    $users->pword = password_hash($data['npsn'], PASSWORD_DEFAULT);
                    $users->lv = 2;

                    $datajenjang = $this->db->table('hazedu_sp_jenjang')->where('npsn', $data['npsn'])->get()->getResultArray();
                    $foreach = [];

                    if (count($datajenjang) == 0) {
                        foreach ($data['jenjang'] as $jenjang) {
                            $foreach[] = $jenjang;

                            $this->db->table('hazedu_sp_jenjang')->insert([
                                'uid_jenjang' => 'J' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6),
                                'npsn' => $data['npsn'],
                                'jenjang' => $jenjang
                            ]);
                        }

                        if ($this->login->insert($users)) {
                            return $this->response->setJSON(['success' => 'Data berhasil disimpan, silahkan cek email Kamu ya...']);
                        } else {
                            return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
                        }
                    } else {
                        return $this->response->setJSON(['error' => 'Data Jenjang yang ditentukan sudah tersedia!'])->setStatusCode(400);
                    }
                } else {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
                }
            }
        }
    }

    public function edit($id = null)
    {
        if ($id) {
            $query = $this->sp->where('uid_sp', $id)->first();
            $user = $this->login->where('uname', $query['npsn'])->first();
            $provinsi = $this->provinsi->orderBy('name', 'ASC')->findAll();
            $datajenjang = $this->db->table('hazedu_sp_jenjang')->where('npsn', $query['npsn'])->get()->getResultArray();

            $array = [];
            foreach ($datajenjang as $inputval) {
                // $array[] = $inputval['jenjang'];
                if ($inputval['jenjang'] == 'SMA') {
                    $array[] = $inputval['jurusan'];
                } else {
                    $array[] = $inputval['jenjang'];
                }
            }

            return $this->response->setJSON([
                "title" => 'Edit Satuan Pendidikan',
                "npsn" => $query['npsn'],
                "satuanpendidikan" => $query['sp'],
                "jenis" => $query['jenis'],
                "status" => $query['status'],
                "jenjang" => $array,
                "kepsek" => $query['kepsek'],
                "nip" => $query['nip'],
                "alamat" => $query['alamat'],
                "kelurahan" => $query['kelurahan'],
                "kecamatan" => $query['kecamatan'],
                "kabupaten" => $query['kabupaten'],
                "provinsi" => $query['provinsi'],
                "telepon" => $query['telp'],
                "email" => $query['email'],
                "website" => str_replace('https://', '', $query['website']),
                "namaoperator" => $user['fname'],
                "emailoperator" => $user['eml'],
                "telpoperator" => $user['hp'],
                "action" => '/sp/update/' . $id,
            ]);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function update($id)
    {
        $query = $this->sp->find($id);
        $queryUser = $this->login->where('uname', $query['npsn'])->first();

        $data = $this->request->getPost();
        $validate = $this->validate([
            'npsn' => [
                'rules' => ($data['npsn'] == $query['npsn']) ? 'required' : 'required|is_unique[hazedu_sp.npsn,{npsn}]',
                'errors' => [
                    'required' => 'NPSN wajib diisi ya...',
                    'is_unique' => 'NPSN sudah terdaftar!'
                ],
            ],
            'satuanpendidikan' => [
                'rules' => ($data['satuanpendidikan'] == $query['sp']) ? 'required' : 'required|is_unique[hazedu_sp.sp,npsn,{npsn}]',
                'errors' => [
                    'required' => 'Satuan Pendidikan wajib diisi ya...',
                    'is_unique' => 'Satuan Pendidikan sudah terdaftar!'
                ],
            ],
            'kepsek' => [
                'rules' => ($data['kepsek'] == $query['kepsek']) ? 'required' : 'required|is_unique[hazedu_sp.kepsek,npsn,{npsn}]',
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
                'rules' => ($data['telepon'] == $query['telp']) ? 'required' : 'required|is_unique[hazedu_sp.telp,npsn,{npsn}]|min_length[11]',
                'errors' => [
                    'required' => 'Nomor Handphone sekolah wajib diisi ya...',
                    'is_unique' => 'No. Handphone sekolah sudah terdaftar!',
                    'min_length' => 'No. Handphone minimal 11 angka ya...'
                ],
            ],
            'email' => [
                'rules' => ($data['email'] == $query['email']) ? 'required' : 'required|valid_email|is_unique[hazedu_sp.email,npsn,{npsn}]',
                'errors' => [
                    'required' => 'Email wajib diisi ya...',
                    'valid_email' => 'Format email tidak valid!',
                    'is_unique' => 'Email sekolah sudah terdaftar!'
                ],
            ],
            'website' => [
                'rules' => ($data['website'] == $query['website']) ? 'required' : 'required|valid_url_strict[https]|is_unique[hazedu_sp.website,npsn,{npsn}]',
                'errors' => [
                    'required' => 'Email wajib diisi ya...',
                    'valid_url_strict' => 'Format URL tidak valid!',
                    'is_unique' => 'Website sudah terdaftar!'
                ],
            ],
            'namaoperator' => [
                'rules' => ($data['namaoperator'] == $queryUser['fname']) ? 'required' : 'required|is_unique[hazedu_users.fname,npsn,{npsn}]',
                'errors' => [
                    'required' => 'Nama Operator wajib diisi ya...',
                    'is_unique' => 'Nama Operator sudah terdaftar!'
                ],
            ],
            'emailoperator' => [
                'rules' => ($data['emailoperator'] == $queryUser['eml']) ? 'required' : 'required|valid_email|is_unique[hazedu_users.eml,npsn,{npsn}]',
                'errors' => [
                    'required' => 'Email Operator wajib diisi ya...',
                    'valid_email' => 'Format email tidak valid!',
                    'is_unique' => 'Email operator sudah terdaftar!'
                ],
            ],
            'telpoperator' => [
                'rules' => ($data['telpoperator'] == $queryUser['hp']) ? 'required' : 'required|is_unique[hazedu_users.hp,npsn,{npsn}]|min_length[11]',
                'errors' => [
                    'required' => 'Nomor Handphone operator wajib diisi ya...',
                    'is_unique' => 'No Handphone operator sudah terdaftar!',
                    'min_length' => 'No. Handphone minimal 11 angka ya...'
                ],
            ],
        ]);
        if ($data['jenis'] == 'SMA') {
            $validate .= $this->validate([
                'jenjang' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Jenjang Satuan Pendidikan harus dipilih...',
                    ],
                ],
            ]);
        }
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $acak = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $datajenjang = $this->db->table('hazedu_sp_jenjang')->where('npsn', $query['npsn'])->get()->getResultArray();

            $entiti = new \CodeIgniter\Entity\Entity();
            $entiti->fill($data);
            $entiti->sp = $data['satuanpendidikan'];
            $entiti->jenjang = '';
            $entiti->telp = $data['telepon'];
            $entiti->fname = $data['namaoperator'];
            $entiti->eml = $data['emailoperator'];
            $entiti->hp = $data['telpoperator'];
            $entiti->upddate = date('Y-m-d H:i:s');
            $array = [];

            foreach ($datajenjang as $jenjang) {
                $array[] = $jenjang['jenjang'];
            }

            if ($data['jenis'] == 'SMA' || $data['jenis'] == 'SMK' || $data['jenis'] == 'PKBM') {
                foreach ($data['jenjang'] as $input_val) {
                    if (!in_array($input_val, $array)) {
                        $exp = explode('Paket C ', $input_val);

                        if ($data['jenis'] == 'PKBM') {
                            if ($exp[0] == '') {
                                $this->db->table('hazedu_sp_jenjang')->insert([
                                    'uid_jenjang' => 'J' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6),
                                    'npsn' => $data['npsn'],
                                    'jenjang' => $input_val,
                                    'jurusan' => $exp[1],
                                ]);
                            } else if ($exp[0] != '') {
                                $this->db->table('hazedu_sp_jenjang')->insert([
                                    'uid_jenjang' => 'J' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6),
                                    'npsn' => $data['npsn'],
                                    'jenjang' => $input_val,
                                    'jurusan' => '',
                                ]);
                            }
                        } else {
                            $this->db->table('hazedu_sp_jenjang')->insert([
                                'uid_jenjang' => 'J' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6) . '-' . substr(str_shuffle($acak), 0, 6),
                                'npsn' => $data['npsn'],
                                'jenjang' => $data['jenis'],
                                'jurusan' => $input_val,
                            ]);
                        }
                    }
                    $entiti->jenjang .= $input_val . ', ';
                }

                foreach ($array as $row) {
                    if (!in_array($row, $data['jenjang'])) {
                        $this->db->table('hazedu_sp_jenjang')->where([
                            'npsn' => $query['npsn'],
                            'jenjang' => $row
                        ])->delete();
                    }
                }

                $entiti->jenjang = substr($entiti->jenjang, 0, -2);
            }

            if ($this->sp->update($id, $entiti) && $this->login->update($queryUser['uid'], $entiti)) {
                $session = [
                    'npsn' => $data['npsn'],
                ];

                session()->set($session);

                return $this->response->setJSON(['success' => 'Data berhasil disimpan...']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
            }
        }
    }

    public function details($id = null)
    {
        if ($id) {
            $query = $this->sp->find($id);

            $data = [
                'title' => 'Detail Satuan Pendidikan',
                'titlecontent' => 'Detail Satuan Pendidikan',
                'setting' => $this->apps->first(),
                'datalembaga' => $this->sp->find($id),
                'datalayanan' => $this->db->table('hazedu_jenjang')->get()->getResult(),
                'operator' => $this->login->where('npsn', $query['npsn'])->first(),
                'resultgtk' => $this->gtk->where('npsn', $query['npsn'])->orderBy('nama', 'ASC')->find(),
                'resultpd' => $this->pd->where('npsn', $query['npsn'])->orderBy('nama', 'ASC')->find(),
                'resultrombel' => $this->rombel->where('npsn', $query['npsn'])->orderBy('nama', 'ASC')->find()
            ];

            return view('lembaga/details', $data);
        }
    }

    public function delete($id)
    {
        $delete = $this->sp->delete($id);

        if ($delete) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!!!'])->setStatusCode(400);
        }
    }
}
