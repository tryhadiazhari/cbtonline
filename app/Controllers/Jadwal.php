<?php

namespace App\Controllers;

class Jadwal extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Jadwal Ujian',
            'titlecontent' => 'Jadwal Ujian',
            'breadcrumb' => 'Jadwal Ujian',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'datalayanan' => $this->db->table('hazedu_sp_jenjang')->where('npsn', session()->npsn)->orderBy('jenjang', 'ASC')->get()->getResultArray(),
            'datamapel' => $this->jadwal->where('npsn', session()->npsn)->findAll(),
            'datasesi' => $this->db->table('sesi')->get()->getResultArray(),
            'datajenisujian' => $this->db->table('hazedu_jenis_ujian')->where('status', 'Aktif')->get()->getResultArray(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Jadwal Ujian'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('jadwal', $data);
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

        if (isset($searchValue)) {
            $search = 'npsn = "' . session()->npsn . '" AND (
                mapel LIKE "%' . $searchValue . '%" 
                OR rombel LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"
                OR durasi_ujian LIKE "%' . $searchValue . '%"
                OR tgl_ujian LIKE "%' . $searchValue . '%"
                OR jam_ujian LIKE "%' . $searchValue . '%"
                OR sesi LIKE "%' . $searchValue . '%"
                OR status LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->jadwal->where('mapel LIKE "%' . $searchValue . '%" 
                OR rombel LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"
                OR durasi_ujian LIKE "%' . $searchValue . '%"
                OR tgl_ujian LIKE "%' . $searchValue . '%"
                OR jam_ujian LIKE "%' . $searchValue . '%"
                OR sesi LIKE "%' . $searchValue . '%"
                OR status LIKE "%' . $searchValue . '%"')
            ->countAllResults()
            :
            $this->jadwal->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->jadwal->where('mapel LIKE "%' . $searchValue . '%" 
                OR rombel LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"
                OR durasi_ujian LIKE "%' . $searchValue . '%"
                OR tgl_ujian LIKE "%' . $searchValue . '%"
                OR jam_ujian LIKE "%' . $searchValue . '%"
                OR sesi LIKE "%' . $searchValue . '%"
                OR status LIKE "%' . $searchValue . '%"')
            ->countAllResults()
            :
            $this->jadwal->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->jadwal->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll()
                :
                $this->jadwal->where('mapel LIKE "%' . $searchValue . '%" 
                OR rombel LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"
                OR durasi_ujian LIKE "%' . $searchValue . '%"
                OR tgl_ujian LIKE "%' . $searchValue . '%"
                OR jam_ujian LIKE "%' . $searchValue . '%"
                OR sesi LIKE "%' . $searchValue . '%"
                OR status LIKE "%' . $searchValue . '%"')
                ->orderBy($columnName, $columnSortOrder)
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->jadwal->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start)
                :
                $this->jadwal->where('mapel LIKE "%' . $searchValue . '%" 
                OR rombel LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"
                OR durasi_ujian LIKE "%' . $searchValue . '%"
                OR tgl_ujian LIKE "%' . $searchValue . '%"
                OR jam_ujian LIKE "%' . $searchValue . '%"
                OR sesi LIKE "%' . $searchValue . '%"
                OR status LIKE "%' . $searchValue . '%"')
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
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Jadwal Ujian'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            // $soal = $this->soal->where('uid_banksoal', $key['uid_banksoal'])->find();
            $no++;

            $data = array();
            $data[] = '<div class="form-check form-check-inline">
                            <input type="checkbox" name="cekpilih[]" class="cekpilih form-check-input" id="cekpilih-' . $no . '" value="' . $key['uid_jadwal'] . '">
                    </div>';
            $data[] = $key['mapel'];
            $data[] = ($key['rombel'] == '') ?  $key['tingkatan'] . ' / ' . $key['jurusan'] : $key['rombel'] . ' / ' . $key['tingkatan'] . ' / ' . $key['jurusan'];
            $data[] = $key['durasi_ujian'] . ' Menit';
            $data[] = $key['tgl_ujian'] . ' ' . $key['jam_ujian'];
            $data[] = $key['sesi'];

            if ($key['acak'] == 1 && $key['token'] == 1) {
                $data[] = '<div class="label bg-success bg-gradient">Ya</div> <div class="label bg-success bg-gradient">Ya</div>';
            } else if ($key['acak'] == 1 && $key['token'] == 0) {
                $data[] = '<div class="label bg-success bg-gradient">Ya</div> <div class="label bg-danger bg-gradient">Tidak</div>';
            } else if ($key['acak'] == 0 && $key['token'] == 1) {
                $data[] = '<div class="label bg-danger bg-gradient">Tidak</div> <div class="label bg-success bg-gradient">Ya</div>';
            } else {
                $data[] = '<div class="label bg-danger bg-gradient">Tidak</div> <div class="label bg-danger bg-gradient">Tidak</div>';
            }

            if($key['tgl_ujian'] == date('Y-m-d') && $key['jam_ujian'] <= date('H:i:s'))
            {
                $data[] = '<div class="label bg-success bg-gradient">Sudah Mulai</div>';
            }
            if($key['tgl_ujian'] == date('Y-m-d') && $key['jam_ujian'] >= date('H:i:s'))
            {
                $data[] = '<div class="label bg-danger bg-gradient">Belum Mulai</div>';
            }
            else
            {
                $data[] = '<div class="label bg-success bg-gradient">Sudah Berakhir</div>';
            }

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit mr-1 px-2" data-id="' . $key['uid_jadwal'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_jadwal'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_jadwal'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit px-2" data-id="' . $key['uid_jadwal'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_jadwal'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_jadwal'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            }

            $data['id'] = $key['uid_jadwal'];

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
        $validate = $this->validation->run($data, 'jadwalvalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $mapel = $this->banksoal->where('uid_banksoal', 'BS-' . $data['mapel'])->first();
            $jadwal = new \CodeIgniter\Entity\Entity();
            $jadwal->fill($data);
            $jadwal->uid_jadwal = time();
            $jadwal->npsn = session()->npsn;
            $jadwal->uid_banksoal = $mapel['uid_banksoal'];
            $jadwal->kode_ujian = $data['jenisujian'];
            $jadwal->gtk = $mapel['gtk'];
            $jadwal->mapel = ($mapel['kategori'] != '') ? $mapel['mapel'] . ' ' . $mapel['kategori'] : $mapel['mapel'];
            $jadwal->kategori = $mapel['kategori'];
            $jadwal->jurusan = $mapel['jurusan'];
            $jadwal->rombel = (empty($data['romble'])) ? '' : $data['romble'];
            $jadwal->jml_pg = $mapel['jml_pg'];
            $jadwal->bobot_pg = $mapel['bobot_pg'];
            $jadwal->opsi = $mapel['opsi'];
            $jadwal->jml_esai = $mapel['jml_esai'];
            $jadwal->bobot_esai = $mapel['bobot_esai'];
            $jadwal->durasi_ujian = $data['durasi'];
            $jadwal->tgl_ujian = $data['tglujian'];
            $jadwal->jam_ujian = $data['timer'];
            $jadwal->tgl_expired = $data['tglexpired'];
            $jadwal->status = 1;

            $checked = $this->jadwal->where('uid_banksoal', $mapel['uid_banksoal'])->find();

            if (count($checked) == 0) {
                if ($this->jadwal->insert($jadwal)) {
                    return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                } else {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
                }
            } else {
                return $this->response->setJSON(['error' => 'Jadwal Ujian sudah ada'])->setStatusCode(400);
            }
        }
    }

    public function edit($id, $action = null)
    {
        $query = $this->jadwal->where('uid_jadwal', $id)->first();

        if ($action == '') {
            $data = [
                'npsn' => $query['npsn'],
                'jenjang' => $query['jenjang'],
                'tingkatan' => $query['tingkatan'],
                'romble' => $query['rombel'],
                'kode' => str_replace('BS-', '', $query['uid_banksoal']),
                'mapel' => $query['mapel'],
                'categories' => $query['kategori'],
                'guru' => $query['gtk'],
                'jenjang' => $query['jenjang'],
                'jurusan' => $query['jurusan'],
                'jenisujian' => $query['kode_ujian'],
                'sesi' => $query['sesi'],
                'tglujian' => $query['tgl_ujian'],
                'timer' => $query['jam_ujian'],
                'tglexpired' => $query['tgl_expired'],
                'durasi' => $query['durasi_ujian'],
                'kkm' => $query['kkm'],
                'acak' => $query['acak'],
                'token' => $query['token'],
            ];

            return $this->response->setJSON($data);
        } else if ($action == 'save') {
            $data = $this->request->getPost();
            $validate = $this->validation->run($data, 'jadwalvalidate');
            $errors = $this->validation->getErrors();

            if ($errors) {
                return $this->response->setJSON($errors)->setStatusCode(404);
            } else {
                $mapel = $this->banksoal->where('uid_banksoal', 'BS-' . $data['mapel'])->first();
                $jadwal = new \CodeIgniter\Entity\Entity();
                $jadwal->fill($data);
                $jadwal->uid_jadwal = $id;
                $jadwal->npsn = session()->npsn;
                $jadwal->uid_banksoal = $mapel['uid_banksoal'];
                $jadwal->kode_ujian = $data['jenisujian'];
                $jadwal->gtk = $mapel['gtk'];
                $jadwal->mapel = ($mapel['kategori'] != '') ? $mapel['mapel'] . ' ' . $mapel['kategori'] : $mapel['mapel'];
                $jadwal->kategori = $mapel['kategori'];
                $jadwal->jurusan = $mapel['jurusan'];
                $jadwal->rombel = (empty($data['romble'])) ? '' : $data['romble'];
                $jadwal->jml_pg = $mapel['jml_pg'];
                $jadwal->bobot_pg = $mapel['bobot_pg'];
                $jadwal->opsi = $mapel['opsi'];
                $jadwal->jml_esai = $mapel['jml_esai'];
                $jadwal->bobot_esai = $mapel['bobot_esai'];
                $jadwal->durasi_ujian = $data['durasi'];
                $jadwal->tgl_ujian = $data['tglujian'];
                $jadwal->jam_ujian = $data['timer'];
                $jadwal->tgl_expired = $data['tglexpired'];
                $jadwal->status = 1;

                if (isset($data['acak'])) {
                    $jadwal->acak = $data['acak'];
                } else {
                    $jadwal->acak = 0;
                }
                if (isset($data['token'])) {
                    $jadwal->token = $data['token'];
                } else {
                    $jadwal->token = 0;
                }

                if ($this->jadwal->update($id, $jadwal)) {
                    return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                } else {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
                }
            }
        }
    }

    public function delete($id)
    {
        if ($this->jadwal->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!'])->setStatusCode(400);
        }
    }

    public function deleteall()
    {
        $data = $this->request->getPost();

        if ($this->jadwal->whereIn('uid_jadwal', $data['id'])->delete()) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!'])->setStatusCode(400);
        }
    }
}
