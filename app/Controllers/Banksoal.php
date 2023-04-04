<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Banksoal extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Bank Soal',
            'titlecontent' => 'Bank Soal',
            'breadcrumb' => 'Bank Soal',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'datalayanan' => $this->db->table('hazedu_sp_jenjang')->where('npsn', session()->npsn)->orderBy('jenjang', 'ASC')->get()->getResultArray(),
            'datagtk' => $this->gtk->where('npsn', session()->npsn)->findAll(),
            'datamapel' => $this->mapel->findAll(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Bank Soal'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('banksoal', $data);
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
            $search = 'npsn = "' . session()->npsn . '" AND (mapel LIKE "%' . $searchValue . '%" 
                OR gtk LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->banksoal->where('mapel LIKE "%' . $searchValue . '%" 
                OR gtk LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"')
            ->countAllResults()
            :
            $this->banksoal->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->banksoal->where('mapel LIKE "%' . $searchValue . '%" 
                OR gtk LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"')
            ->countAllResults()
            :
            $this->banksoal->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->banksoal->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll()
                :
                $this->banksoal->where('mapel LIKE "%' . $searchValue . '%" 
                OR gtk LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"')
                ->orderBy($columnName, $columnSortOrder)
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->banksoal->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start)
                :
                $this->banksoal->where('mapel LIKE "%' . $searchValue . '%" 
                OR gtk LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"
                OR jenjang LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR jurusan LIKE "%' . $searchValue . '%"')
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
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Bank Soal'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $soal = $this->soal->where('uid_banksoal', $key['uid_banksoal'])->find();
            $no++;

            $data = array();
            $data[] = '<div class="form-check form-check-inline">
                            <input type="checkbox" name="cekpilih[]" class="cekpilih form-check-input" id="cekpilih-' . $no . '" value="' . $key['uid_banksoal'] . '">
                    </div>';
            $data[] = $key['mapel'];
            $data[] = $key['jml_pg'] . ' Soal';
            $data[] = $key['jml_esai'] . ' Soal';
            $data[] = (empty($key['rombel'])) ? $key['tingkatan'] . '/' . $key['jenjang'] : $key['rombel'] . ' / ' . $key['tingkatan'];
            $data[] = $key['gtk'];
            $data[] = ($key['status'] == 0) ? '<small class="label label-danger bg-gradient">Tidak Aktif</small>' : '<small class="label label-success bg-gradient">Aktif</small> <small class="label label-success bg-gradient">' . count($soal) . ' Soal</small>';

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit mr-1 px-2" data-id="' . $key['uid_banksoal'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_banksoal'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_banksoal'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit px-2" data-id="' . $key['uid_banksoal'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_banksoal'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_banksoal'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            }

            $data['id'] = $key['uid_banksoal'];

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
        $validate = $this->validation->run($data, 'banksoalvalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $jurusan = $this->db->table('jurusan')->where('jenjang', $data['jenjang'])->get()->getRowArray();
            $mapel = $this->db->table('hazedu_mapel')->where('nama_mapel', $data['mapel'])->get()->getRowArray();

            $soal = new \CodeIgniter\Entity\Entity();
            $soal->fill($data);
            $soal->uid_banksoal = "BS-" . time();
            $soal->npsn = session()->npsn;
            $soal->kode_mapel = $mapel['kode_mapel'];
            $soal->mapel = $data['mapel'];
            $soal->alias = $mapel['alias'];
            $soal->kategori = ($data['mapel'] == 'Pendidikan Agama') ? $data['jenisagama'] : '';
            $soal->gtk = $data['guru'];
            $soal->jurusan = $jurusan['jurusan'];
            $soal->rombel = (empty($data['romble'])) ? '' : $data['romble'];
            $soal->jml_pg = $data['soalpg'];
            $soal->tampil_pg = $data['soalpg'];
            $soal->bobot_pg = $data['bobotpg'];
            $soal->jml_esai = $data['soalesai'];
            $soal->tampil_esai = $data['soalesai'];
            $soal->bobot_esai = $data['bobotesai'];
            $soal->opsi = $data['opsi'];
            $soal->paket_soal = $data['paketsoal'];

            if ($this->banksoal->insert($soal)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
            }
        }
    }

    public function edit($id, $action = null)
    {
        $query = $this->banksoal->where('uid_banksoal', $id)->first();

        if ($action == '') {
            $data = [
                'npsn' => $query['npsn'],
                'mapel' => $query['mapel'],
                'categories' => $query['kategori'],
                'guru' => $query['gtk'],
                'jenjang' => $query['jenjang'],
                'jurusan' => $query['jurusan'],
                'tingkatan' => $query['tingkatan'],
                'romble' => $query['rombel'],
                'soalpg' => $query['jml_pg'],
                'bobotpg' => $query['bobot_pg'],
                'opsi' => $query['opsi'],
                'soalesai' => $query['jml_esai'],
                'bobotesai' => $query['bobot_esai'],
                'paketsoal' => $query['paket_soal'],
                'status' => $query['status'],
            ];

            return $this->response->setJSON($data);
        } else if ($action == 'save') {
            $data = $this->request->getPost();
            $validate = $this->validation->run($data, 'banksoalvalidate');
            $errors = $this->validation->getErrors();

            if ($errors) {
                return $this->response->setJSON($errors)->setStatusCode(404);
            } else {
                $jurusan = $this->db->table('jurusan')->where('jenjang', $data['jenjang'])->get()->getRowArray();
                $mapel = $this->db->table('hazedu_mapel')->where('nama_mapel', $data['mapel'])->get()->getRowArray();

                $soal = new \CodeIgniter\Entity\Entity();
                $soal->fill($data);
                $soal->kode_mapel = $mapel['kode_mapel'];
                $soal->mapel = $data['mapel'];
                $soal->alias = $mapel['alias'];
                $soal->kategori = ($data['mapel'] == 'Pendidikan Agama') ? $data['jenisagama'] : '';
                $soal->gtk = $data['guru'];
                $soal->jurusan = $jurusan['jurusan'];
                $soal->rombel = (empty($data['romble'])) ? '' : $data['romble'];
                $soal->jml_pg = $data['soalpg'];
                $soal->tampil_pg = $data['soalpg'];
                $soal->bobot_pg = $data['bobotpg'];
                $soal->jml_esai = $data['soalesai'];
                $soal->tampil_esai = $data['soalesai'];
                $soal->bobot_esai = $data['bobotesai'];
                $soal->opsi = $data['opsi'];
                $soal->paket_soal = $data['paketsoal'];

                if ($this->banksoal->update($id, $soal)) {
                    return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                } else {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
                }
            }
        }
    }

    public function delete($id)
    {
        if ($this->banksoal->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!'])->setStatusCode(400);
        }
    }

    public function deleteall()
    {
        $data = $this->request->getPost();

        if ($this->banksoal->whereIn('uid_banksoal', $data['id'])->delete()) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!'])->setStatusCode(400);
        }
    }
}
