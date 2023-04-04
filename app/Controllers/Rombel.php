<?php

namespace App\Controllers;

class Rombel extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Rombongan Belajar',
            'titlecontent' => 'Rombongan Belajar',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            // 'datasiswa' => $this->pd->where('rombel', '')->find(),
            // 'datajenjang' => $this->db->table('hazedu_sp_jenjang')->where('npsn', session()->npsn)->orderBy('jenjang')->get()->getResultArray(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.import
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Rombongan Belajar'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray(),
        ];

        return view('rombel', $data);
    }

    public function viewdata()
    {
        $dtpost = $this->request->getPost();
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowPerPage = $dtpost['length'];
        $columnIndex = $dtpost['order'][0]['column'];
        $columnName = $dtpost['columns'][$columnIndex]['data'];
        $columnSortOrder = $dtpost['order'][0]['dir'];
        $searchValue = $dtpost['search']['value'];

        if ($dtpost['search']['value']) {
            $search = 'npsn = "' . session()->npsn . '" AND (
                npsn LIKE "%' . $searchValue . '%" 
                OR jenis_rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR kurikulum LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%",
                OR wali_kelas LIKE "%' . $searchValue . '%",
                OR ruang LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->rombel->where('npsn LIKE "%' . $searchValue . '%" 
                OR jenis_rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR kurikulum LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%",
                OR wali_kelas LIKE "%' . $searchValue . '%",
                OR ruang LIKE "%' . $searchValue . '%"')->countAllResults() : $this->rombel->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->rombel->where('npsn LIKE "%' . $searchValue . '%" 
                OR jenis_rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR kurikulum LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%",
                OR wali_kelas LIKE "%' . $searchValue . '%",
                OR ruang LIKE "%' . $searchValue . '%"')->countAllResults() : $this->rombel->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->rombel->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start) : $this->rombel->where('npsn LIKE "%' . $searchValue . '%" 
                OR jenis_rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR kurikulum LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%",
                OR wali_kelas LIKE "%' . $searchValue . '%",
                OR ruang LIKE "%' . $searchValue . '%"')
                ->orderBy($columnName, $columnSortOrder)
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->rombel->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start) : $this->rombel->where('npsn LIKE "%' . $searchValue . '%" 
                OR jenis_rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR kurikulum LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%",
                OR wali_kelas LIKE "%' . $searchValue . '%",
                OR ruang LIKE "%' . $searchValue . '%"')
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start);
        }

        $akses = $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Rombongan Belajar'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = $no;
            $data['jenis_rombel'] = $key['jenis_rombel'];
            $data['jenjang'] = $key['jenjang'];
            $data['tingkatan'] = $key['tingkatan'];
            $data['kurikulum'] = $key['kurikulum'];
            $data['nama'] = $key['nama'];
            $data['wali_kelas'] = $key['wali_kelas'];
            $data['ruang'] = $key['ruang'];

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data['action'] = '<div class="text-center">
                <button type="button" class="btn btn-sm btn-secondary btn-edit mr-1" data-id="' . $key['uid_rombel'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_rombel'] . '"><i class="fas fa-pencil fa-sm"></i></button>
                <button type="button" class="btn btn-sm btn-danger btn-delete" data-href="' . $explode[0] . 'delete/' . $key['uid_rombel'] . '"><i class="fas fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data['action'] = '<div class="text-center">
                <button type="button" class="btn btn-xs btn-secondary btn-edit px-2" data-id="' . $key['uid_rombel'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_rombel'] . '"><i class="fas fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data['action'] = '<div class="text-center">
                <button type="button" class="btn btn-xs btn-danger btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_rombel'] . '"><i class="fas fa-trash fa-sm"></i></button>
                </div>';
            } else {
                $data['action'] = '';
            }

            $data['DT_RowId'] = $key['uid_rombel'];
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
        $validate = $this->validation->run($data, 'rombelvalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $rombel = new \CodeIgniter\Entity\Entity();
            $rombel->fill($data);
            $rombel->uid_rombel = 'RBL-' . $data['npsn'] . '-' . time();
            $rombel->jenis_rombel = $data['jenisrombel'];
            $rombel->nama = $data['namarombel'];
            $rombel->wali_kelas = $data['walikelas'];

            if ($this->rombel->insert($rombel)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan...']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
            }
        }
    }

    public function edit($id = null, $action = null)
    {
        if ($id) {
            $query = $this->rombel->where('uid_rombel', $id)->first();

            if ($action == '') {
                return $this->response->setJSON([
                    'id' => $query['uid_rombel'],
                    'npsn' => $query['npsn'],
                    'jenis' => $query['jenis_rombel'],
                    'kompetensi' => $query['jenjang'],
                    'tingkatan' => $query['tingkatan'],
                    'kurikulum' => $query['kurikulum'],
                    'rombel' => $query['nama'],
                    'wali' => $query['wali_kelas'],
                    'ruang' => $query['ruang'],
                ]);
            } else if ($action == 'save') {
                $data = $this->request->getPost();
                $validate = $this->validate([
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
                        'rules' => ($query['nama'] == $data['namarombel']) ? 'required' : 'required|is_unique[hazedu_rombel.nama,npsn,npsn]',
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
                        'rules' => ($query['ruang'] == $data['ruang']) ? 'required' : 'required|is_unique[hazedu_rombel.ruang,npsn,npsn]',
                        'errors' => [
                            'required' => 'Masukkan nama ruang untuk rombel',
                            'is_unique' => 'Nama {value} sudah ada!'
                        ]
                    ],
                ]);
                $errors = $this->validation->getErrors();

                if ($errors) {
                    return $this->response->setJSON($errors)->setStatusCode(404);
                } else {
                    $rombel = new \CodeIgniter\Entity\Entity();
                    $rombel->fill($data);
                    $rombel->jenis_rombel = $data['jenisrombel'];
                    $rombel->nama = $data['namarombel'];
                    $rombel->wali_kelas = $data['walikelas'];

                    if ($this->rombel->update($id, $rombel)) {
                        return $this->response->setJSON(['success' => 'Data berhasil disimpan...']);
                    } else {
                        return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
                    }
                }
            }
        }
    }

    public function anggotarombel($id, $action = null, $idsiswa = null)
    {
        $query = $this->rombel->where('uid_rombel', $id)->first();

        if ($action == '') {
            return $this->response->setJSON([
                'title' => 'Anggota Rombel ' . $query['nama'],
                'id' => $query['uid_rombel'],
                'jenjang' => $query['jenjang'],
                'tingkatan' => $query['tingkatan'],
                'rombel' => $query['nama']
            ]);
        } else if ($action == 'save') {
            $ids = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis');

            $data = array();
            foreach ($ids as $j => $key) {
                $data[] = array(
                    'uid_siswa' => $ids[$j],
                    'rombel' => $query['nama'],
                    'tingkatan' => $query['tingkatan'],
                    'jenis_daftar' => $jenis,
                );
            }

            if ($this->pd->updateBatch($data, 'uid_siswa')) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
            }
        } else if ($action == 'delete') {
            $ids = $this->request->getVar('id');

            $data = array();
            foreach ($ids as $j => $key) {
                $data[] = array(
                    'uid_siswa' => $ids[$j],
                    'rombel' => '',
                    'tingkatan' => '',
                    'jenis_daftar' => '',
                );
            }

            if ($this->pd->updateBatch($data, 'uid_siswa')) {
                return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal dihapus'])->setStatusCode(400);
            }
        }
    }

    public function delete($id)
    {
        if ($this->rombel->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus'])->setStatusCode(400);
        }
    }
}
