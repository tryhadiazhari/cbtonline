<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PdAccount extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Akun Peserta Didik',
            'titlecontent' => 'Akun Peserta Didik',
            'breadcrumb' => 'Akun Peserta Didik',
            'setting' => $this->apps->first(),
            'datasiswa' => $this->pd->findAll(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'satuanpendidikan' => (session()->lv == 1) ? $this->sp->orderBy('sp', 'ASC')->findAll() : $this->sp->where('npsn', session()->npsn)->find(),
            'datasesi' => $this->db->table('sesi')->get()->getResultArray(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Akun Peserta Didik'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('pdidik/account', $data);
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
                npsn LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = (session()->lv == 1) ? $this->pd
            ->where('npsn LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"')
            ->countAllResults() : $this->pd->where($search)->countAllResults();

        $totalRowsWithFilter = (session()->lv == 1) ? $this->pd
            ->where('npsn LIKE "%' . $searchValue . '%"
                OR nama LIKE "%' . $searchValue . '%" 
                OR nisn LIKE "%' . $searchValue . '%"
                OR jk LIKE "%' . $searchValue . '%"
                OR tingkatan LIKE "%' . $searchValue . '%"
                OR rombel LIKE "%' . $searchValue . '%"')
            ->countAllResults() : $this->pd->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = (session()->lv == 2) ? $this->pd
                ->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll() : $this->pd
                ->where('npsn LIKE "%' . $searchValue . '%"
                    OR nama LIKE "%' . $searchValue . '%" 
                    OR nisn LIKE "%' . $searchValue . '%"
                    OR jk LIKE "%' . $searchValue . '%"
                    OR tingkatan LIKE "%' . $searchValue . '%"
                    OR rombel LIKE "%' . $searchValue . '%"')
                ->orderBy($columnName, $columnSortOrder)
                ->findAll();
        } else {
            $records = (session()->lv == 2) ? $this->pd
                ->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->findAll($rowPerPage, $start) : $this->pd
                ->where('npsn LIKE "%' . $searchValue . '%"
                    OR nama LIKE "%' . $searchValue . '%" 
                    OR nisn LIKE "%' . $searchValue . '%"
                    OR jk LIKE "%' . $searchValue . '%"
                    OR tingkatan LIKE "%' . $searchValue . '%"
                    OR rombel LIKE "%' . $searchValue . '%"')
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
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Akun Peserta Didik'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = $no;
            $data[] = $key['nama'];
            $data[] = (empty($key['no_peserta'])) ? '-' : $key['no_peserta'];
            $data[] = ($key['uname'] == '') ? '-' : $key['uname'];
            $data[] = ($key['pword'] == '') ? '-' : $key['pword'];
            $data[] = ($key['sesi'] == '') ? '-' : $key['sesi'];

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit mr-1 px-2" data-id="' . $key['uid_siswa'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_siswa'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_siswa'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit px-2" data-id="' . $key['uid_siswa'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_siswa'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_siswa'] . '"><i class="fa fa-trash fa-sm"></i></button>
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

    public function edit($id = null, $action = null)
    {
        if ($id) {
            $query = $this->pd->where('uid_siswa', $id)->first();

            if ($action == '') {
                return $this->response->setJSON([
                    'npsn' => $query['npsn'],
                    'nama' => $query['nama'],
                    'nopes' => $query['no_peserta'],
                    'username' => $query['uname'],
                    'password' => $query['pword'],
                    'sesi' => $query['sesi'],
                    'action' => '/pdaccount/edit/' . $id . '/save',
                ]);
            } else if ($action == 'save') {
                $data = $this->request->getPost();
                $validate = $this->validate([
                    'nopes' => [
                        'rules' => ($data['nopes'] == $query['no_peserta']) ? 'required' : 'required|is_unique[hazedu_siswa.no_peserta,npsn,{' . session()->npsn . '}]',
                        'errors' => [
                            'required' => 'Nomor Peserta wajib diisi ya...',
                            'is_unique' => 'Nomor Peserta sudah tersedia!'
                        ]
                    ],
                    'username' => [
                        'rules' => ($data['username'] == $query['uname']) ? 'required' : 'required|is_unique[hazedu_siswa.uname,npsn,{' . session()->npsn . '}]',
                        'errors' => [
                            'required' => 'Username wajib diisi ya...',
                            'is_unique' => 'Username sudah tersedia!'
                        ]
                    ],
                    'password' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Password wajib diisi ya...',
                        ]
                    ],
                    'sesi' => [
                        'rules' => 'required',
                        'errors' => [
                            'required' => 'Sesi wajib dipilih ya...',
                        ]
                    ],
                ]);

                $errors = $this->validation->getErrors();

                if ($errors) {
                    return $this->response->setJSON($errors)->setStatusCode(404);
                } else {
                    $pd = new \CodeIgniter\Entity\Entity();
                    $pd->fill($data);
                    $pd->no_peserta = $data['nopes'];
                    $pd->uname = $data['username'];
                    $pd->pword = $data['password'];
                    $pd->sesi = $data['sesi'];

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

    public function export()
    {
        $query = $this->pd->where('npsn', session()->npsn)->find();
        $sp = $this->sp->where('npsn', session()->npsn)->first();

        $spreadsheet = new Spreadsheet();
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Akun Ujian');
        $spreadsheet->addSheet($myWorkSheet, 0);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Data Akun Ujian')
            ->setCellValue('A2', strtoupper($sp['sp']))
            ->setCellValue('A3', 'Kecamatan ' . ucwords(strtolower($sp['kecamatan'])) . ', Kabupaten ' . ucwords(strtolower($sp['kabupaten'])) . ', Provinsi ' . ucwords(strtolower($sp['provinsi'])))
            ->setCellValue('A4', 'Tanggal Unduh : ' . date('Y-m-d H:i:s'))
            ->setCellValue('A6', 'No')
            ->setCellValue('B6', 'Nama')
            ->setCellValue('C4', 'Pengunduh : ' . session()->fname . ' (' . $sp['email'] . ')')
            ->setCellValue('C6', 'No Peserta')
            ->setCellValue('D6', 'Username')
            ->setCellValue('E6', 'Password')
            ->setCellValue('F6', 'Sesi');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(80, 'pt');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(6, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(3, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(3, 'cm');
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

        $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(25);

        $spreadsheet->getActiveSheet()->getStyle('A1:A2')
            ->applyFromArray([
                'font' => [
                    'bold' => true,
                    'size' => 16,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ])
            ->getActiveSheet()->getStyle('A6:F6')->applyFromArray([
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => [
                        'argb' => '00FFFF',
                    ],

                ],
            ]);

        $column = 7;

        $spreadsheet->getActiveSheet()
            ->getComment('D6')
            ->setWidth(150)
            ->setHeight(80);
        $commentRichText = $spreadsheet->getActiveSheet()
            ->getComment('D6')
            ->getText()->createTextRun("Peringatan:");
        $commentRichText->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->getComment('D6')
            ->getText()->createTextRun("\r\nUsername harus terdiri dari gabungan huruf kapital dan angka\r\nCth: X0123456");

        $spreadsheet->getActiveSheet()
            ->getComment('E6')
            ->setWidth(150)
            ->setHeight(80);
        $commentRichText = $spreadsheet->getActiveSheet()
            ->getComment('E6')
            ->getText()->createTextRun("Peringatan:");
        $commentRichText->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()
            ->getComment('E6')
            ->getText()->createTextRun("\r\nPassword harus terdiri dari gabungan huruf kapital, angka dan simbol *\r\nCth: X0123456*");

        foreach ($query as $data) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $data['uid_siswa'])
                ->setCellValue('B' . $column, $data['nama'])
                ->setCellValue('C' . $column, $data['no_peserta'])
                ->setCellValue('D' . $column, $data['uname'])
                ->setCellValue('E' . $column, $data['pword'])
                ->setCellValue('F' . $column, $data['sesi']);

            $spreadsheet->getActiveSheet()
                ->getCell('F' . $column)
                ->getDataValidation()
                ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
                ->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION)
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('Input error')
                ->setError('Value is not in list.')
                ->setFormula1('"1,2,3,4,5"');

            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data-Rombel-' . $sp['sp'];
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function import()
    {
        $data = $this->request->getPost('file');
        $validate = $this->validation->run($data, 'importvalidate');
        $error = $this->validation->getError();

        if ($error) {
            return $this->response->setJSON($error)->setStatusCode(404);
        } else {
            $getFile = $this->request->getFile('file');
            $getExtension = $getFile->getClientExtension();

            if ($getExtension == 'xlsx') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                return $this->response->setJSON(['error' => '<div class="alert alert-danger alert-dismissible" aria-hidden="false" tabindex="-1" role="alert"><i class="icon fa fa-exclamation-triangle"></i> Format file tidak didukung!!!</div>'])->setStatusCode(404);
            }

            $spreadsheet = $render->load($getFile);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $sukses = $gagal = 0;

            // return $this->response->setJSON(['error' => count($spreadsheet->getActiveSheet()->getColumnDimensions())])->setStatusCode(400);
            if (count($spreadsheet->getActiveSheet()->getColumnDimensions()) != 6) {
                return $this->response->setJSON(['error' => '<div class="alert alert-danger alert-dismissible" aria-hidden="false" tabindex="-1" role="alert"><i class="icon fa fa-exclamation-triangle"></i>File tidak Asli!!!</div>'])->setStatusCode(500);
            } else {
                foreach ($data as $x => $row) {
                    if ($x == 0) {
                        continue;
                    } else {
                        $cek = $this->pd->where([
                            'npsn' => session()->npsn,
                            'uid_siswa' => $row[0],
                        ])->countAllResults();

                        if ($cek > 0) {
                            if ($row[1] <> '') {
                                $exec = $this->pd->update($row[0], [
                                    'no_peserta' => (empty($row[2])) ? '' : $row[2],
                                    'uname' => (empty($row[3])) ? '' : $row[3],
                                    'pword' => (empty($row[4])) ? '' : $row[4],
                                    'sesi' => (empty($row[5])) ? '' : $row[5],
                                ]);
                                ($exec) ? $sukses++ : $gagal++;
                            } else {
                                $gagal++;
                            }
                        } else {
                            return $this->response->setJSON([
                                'error' => 'Tidak ada data tersedia!!!',
                                'data' => '<div class="alert alert-danger alert-dismissible" aria-hidden="false" tabindex="-1" role="alert"><i class="icon fa fa-exclamation-triangle"></i>Tidak ada data tersedia!!!</div>'
                            ])->setStatusCode(400);
                        }
                    }
                }

                if ($sukses) {
                    return $this->response->setJSON([
                        'success' => 'Data berhasil disimpan',
                        'data' => '<div class="alert alert-success alert-dismissible" aria-hidden="false" tabindex="-1" role="alert">
                                Berhasil: <strong class="text-light">' . $sukses . ' Data</strong><br />
                                Gagal: <strong class="text-light">' . $gagal . ' Data</strong><br />
                                Dari: <strong class="text-light">' . $x . ' Data</strong>
                            </div>'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => 'Data gagal disimpan',
                        'data' => '<div class="alert alert-danger alert-dismissible" aria-hidden="false" tabindex="-1" role="alert">
                                Berhasil: <strong class="text-light">' . $sukses . ' Data</strong><br />
                                Gagal: <strong class="text-light">' . $gagal . ' Data</strong><br />
                                Dari: <strong class="text-light">' . $x . ' Data</strong>
                            </div>'
                    ])->setStatusCode(400);
                }
            }
        }
    }

    public function generatepass()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return $this->response->setJSON(['pass' => substr(str_shuffle($chars), 0, rand(6, 8)) . '*']);
    }
}
