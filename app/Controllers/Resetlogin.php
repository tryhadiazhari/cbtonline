<?php

namespace App\Controllers;

class Resetlogin extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Reset Login',
            'titlecontent' => 'Reset Login',
            'breadcrumb' => 'Reset Login',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Reset Login'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('reset_login', $data);
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
                OR nama LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = $this->pd->join('login', 'login.id_siswa = hazedu_siswa.uid_siswa')->where('npsn', session()->npsn)->countAllResults();

        $totalRowsWithFilter = $this->pd->join('login', 'login.id_siswa = hazedu_siswa.uid_siswa')->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->pd->join('login', 'login.id_siswa = hazedu_siswa.uid_siswa')->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start) : $this->pd->join('login', 'login.id_siswa = hazedu_siswa.uid_siswa')->where('npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"')
                ->orderBy($columnName, $columnSortOrder)
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->pd->join('login', 'login.id_siswa = hazedu_siswa.uid_siswa')->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start) : $this->pd->join('login', 'login.id_siswa = hazedu_siswa.uid_siswa')->where('npsn LIKE "%' . $searchValue . '%" 
                OR nama LIKE "%' . $searchValue . '%"')
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
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Reset Login'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = '<div class="form-check form-check-inline">
                            <input type="checkbox" name="cekpilih[]" class="cekpilih form-check-input" id="cekpilih-' . $no . '" value="' . $key['uid_siswa'] . '">
                    </div>';
            $data[] = $key['nisn'];
            $data[] = $key['nama'];
            $data[] = $key['tingkatan'] . ' / ' . $key['rombel'];
            $data[] = $key['ipaddress'];
            $data[] = date('d-m-Y H:i', strtotime($key['date']));

            $data['DT_RowId'] = $key['uid_siswa'];
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

    public function request()
    {
        $data = $this->request->getPost();

        if ($this->db->table('login')->whereIn('id_siswa', $data['id'])->delete()) {
            return $this->response->setJSON(['success' => 'Data berhasil di reset ulang']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal di reset!'])->setStatusCode(400);
        }
    }
}
