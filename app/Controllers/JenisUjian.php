<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class JenisUjian extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Jenis Ujian',
            'titlecontent' => 'Jenis Ujian',
            'breadcrumb' => 'Jenis Ujian',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, 
                            hazedu_menu.kode_menu, hazedu_menu.menu_name, hazedu_menu.url, 
                            hazedu_menu.icon, hazedu_menu.sort, hazedu_menu_access.lvl, 
                            hazedu_menu_access.`add`, hazedu_menu_access.`import`, 
                            hazedu_menu_access.`export`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Jenis Ujian'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('jenisujian', $data);
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
                OR alias LIKE "%' . $searchValue . '%"
                OR status LIKE "%' . $searchValue . '%")';
        } else {
            $search = 'npsn = "' . session()->npsn . '"';
        }

        $totalRows = $this->db->table('hazedu_jenis_ujian')->where($search)->countAllResults();

        $totalRowsWithFilter = $this->db->table('hazedu_jenis_ujian')->where($search)->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = $this->db->table('hazedu_jenis_ujian')
                ->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->get()->getResultArray();
        } else {
            $records = $this->db->table('hazedu_jenis_ujian')
                ->where($search)
                ->orderBy($columnName, $columnSortOrder)
                ->get($rowPerPage, $start)
                ->getResultArray();
        }

        $akses = $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.edt, hazedu_menu_access.del 
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Jenis Ujian'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray();

        $explode = explode('viewdata', $_SERVER['REQUEST_URI']);

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = $no;
            $data[] = $key['nama'] . ' (' . $key['alias'] . ')';
            $data[] = $key['status'];

            if ($akses['edt'] == 1 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit mr-1 px-2" data-id="' . $key['uid_jenis'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_jenis'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_jenis'] . '"><i class="fa fa-trash fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 1 && $akses['del'] == 0) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-secondary bg-gradient btn-edit px-2" data-id="' . $key['uid_jenis'] . '" data-href="' . $explode[0] . 'edit/' . $key['uid_jenis'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                </div>';
            } else if ($akses['edt'] == 0 && $akses['del'] == 1) {
                $data[] = '<div class="text-center p-0">
                    <button class="btn btn-xs btn-danger bg-gradient btn-delete px-2" data-href="' . $explode[0] . 'delete/' . $key['uid_jenis'] . '"><i class="fa fa-trash fa-sm"></i></button>
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
        $validate = $this->validation->run($data, 'jenisvalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $query = $this->jenisujian->where('npsn', session()->npsn)->countAllResults();
            $jenis = [
                'uid_jenis' => ($query == 0 || $query < 10 ? 'JJ' . session()->npsn  . '00' . ($query + 1) : ($query >= 10 || $query < 100 ? 'JJ' . session()->npsn  . '0' . ($query + 1) : 'JJ' . session()->npsn . ($query + 1))),
                'npsn' => session()->npsn,
                'nama' => $data['jenis'],
                'alias' => $data['alias'],
                'status' => $data['status']
            ];

            if ($this->db->table('hazedu_jenis_ujian')->insert($jenis)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
            }
        }
    }

    public function edit($id, $action = null)
    {
        $query = $this->db->table('hazedu_jenis_ujian')->where('uid_jenis', $id)->get()->getRowArray();

        if ($action == null) {
            return $this->response->setJSON([
                'npsn' => $query['npsn'],
                'jenis' => $query['nama'],
                'singkatan' => $query['alias'],
                'status' => $query['status'],
                'action' => $_SERVER['REQUEST_URI'] . '/save'
            ]);
        } else if ($action == 'save') {
            $data = $this->request->getPost();
            $validate = $this->validate([
                'jenis' => [
                    'rules' => ($data['jenis'] == $query['nama']) ? 'required' : 'required|is_unique[hazedu_jenis_ujian.nama,npsn,{' . session()->npsn . '}]',
                    'errors' => [
                        'required' => 'Jenis Ujian tidak boleh kosong ya...',
                        'is_unique' => 'Nama jenis ujian sudah ada!!!'
                    ]
                ],
                'alias' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Tidak boleh kosong ya...',
                    ]
                ],
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status wajib dipilih ya...',
                    ]
                ],
            ]);
            $errors = $this->validation->getErrors();

            if ($errors) {
                return $this->response->setJSON($errors)->setStatusCode(404);
            } else {
                $jenis = [
                    'nama' => $data['jenis'],
                    'alias' => $data['alias'],
                    'status' => $data['status'],
                ];

                if ($this->db->table('hazedu_jenis_ujian')->where('uid_jenis', $id)->update($jenis)) {
                    return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
                } else {
                    return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
                }
            }
        }
    }

    public function delete($id)
    {
        if ($this->db->table('hazedu_jenis_ujian')->where('uid_jenis', $id)->delete()) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus'])->setStatusCode(400);
        }
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

                $spreadsheet = $render->load($getFile);
                $data = $spreadsheet->getActiveSheet()->toArray();

                $sukses = $gagal = 0;

                // return $this->response->setJSON(['error' => count($spreadsheet->getActiveSheet()->getColumnDimensions())])->setStatusCode(400);
                if (count($spreadsheet->getActiveSheet()->getColumnDimensions()) != 4) {
                    return $this->response->setJSON(['error' => '<div class="alert alert-danger alert-dismissible" aria-hidden="false" tabindex="-1" role="alert"><i class="icon fa fa-exclamation-triangle"></i>File tidak Asli!!!</div>'])->setStatusCode(500);
                } else {
                    foreach ($data as $x => $row) {
                        if ($x == 0) {
                            continue;
                        } else {
                            $cek = $this->jenisujian->where([
                                'npsn' => session()->npsn,
                                'nama' => $row[1],
                            ])->countAllResults();

                            if ($cek == 0) {
                                if ($row[1] <> '') {
                                    $exec = $this->jenisujian->save([
                                        'uid_jenis' => ($x > 0 && $x < 10 ? 'JJ' . session()->npsn  . '00' . ($cek + $x) : ($x >= 10 && $x < 100 ? 'JJ' . session()->npsn  . '0' . ($cek + $x) : 'JJ' . session()->npsn . ($cek + $x))),
                                        'npsn' => session()->npsn,
                                        'nama' => (empty($row[1])) ? '' : $row[1],
                                        'alias' => (empty($row[2])) ? '' : $row[2],
                                        'status' => (empty($row[3])) ? '' : $row[3],
                                    ]);
                                    ($exec) ? $sukses++ : $gagal++;
                                } else {
                                    $gagal++;
                                }
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
            } else {
                return $this->response->setJSON(['error' => '<div class="alert alert-danger alert-dismissible" aria-hidden="false" tabindex="-1" role="alert"><i class="icon fa fa-exclamation-triangle"></i> Format file tidak didukung!!!</div>'])->setStatusCode(404);
            }
        }
    }

    public function export()
    {
        $query = $this->jenisujian->where('npsn', session()->npsn)->find();
        $sp = $this->sp->where('npsn', session()->npsn)->first();

        $spreadsheet = new Spreadsheet();
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Jenis Ujian');
        $spreadsheet->addSheet($myWorkSheet, 0);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Data Jenis Ujian')
            ->setCellValue('A2', strtoupper($sp['sp']))
            ->setCellValue('A3', 'Kecamatan ' . ucwords(strtolower($sp['kecamatan'])) . ', Kabupaten ' . ucwords(strtolower($sp['kabupaten'])) . ', Provinsi ' . ucwords(strtolower($sp['provinsi'])))
            ->setCellValue('A4', 'Tanggal Unduh : ' . date('Y-m-d H:i:s'))
            ->setCellValue('D4', 'Pengunduh : ' . session()->fname . ' (' . $sp['email'] . ')')
            ->setCellValue('A6', 'No')
            ->setCellValue('B6', 'Kode Jenis')
            ->setCellValue('C6', 'Nama Jenis')
            ->setCellValue('D6', 'Singkatan')
            ->setCellValue('E6', 'Status');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(22, 'pt');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(2.5, 'in');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(1, 'in');
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(1, 'in');

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
            ->getActiveSheet()->getStyle('A6:E6')->applyFromArray([
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
        $nomor = 0;

        foreach ($query as $data) {
            $nomor++;
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $column, $nomor)
                ->setCellValue('B' . $column, $data['uid_jenis'])
                ->setCellValue('C' . $column, $data['nama'])
                ->setCellValue('D' . $column, $data['alias'])
                ->setCellValue('E' . $column, $data['status']);

            $column++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Data-JenisUjian-' . $sp['sp'];
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function download()
    {
        $query = $this->mapel->where('npsn', session()->npsn)->find();
        $sp = $this->sp->where('npsn', session()->npsn)->first();

        $spreadsheet = new Spreadsheet();
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'Jenis Ujian');
        $spreadsheet->addSheet($myWorkSheet, 0);

        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama Jenis')
            ->setCellValue('C1', 'Alias')
            ->setCellValue('D1', 'Status');

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(22, 'pt');
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(3, 'in');
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(1, 'in');
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(1, 'in');

        $spreadsheet->getActiveSheet()
            ->getStyle('A1:D1')->applyFromArray([
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

        $column = 2;
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $column, '')
            ->setCellValue('B' . $column, '')
            ->setCellValue('C' . $column, '')
            ->setCellValue('D' . $column, '');

        $spreadsheet->getActiveSheet()
            ->getCell('D' . $column)
            ->getDataValidation()
            ->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST)
            ->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_INFORMATION)
            ->setAllowBlank(false)
            ->setShowInputMessage(true)
            ->setShowErrorMessage(true)
            ->setShowDropDown(true)
            ->setErrorTitle('Input error')
            ->setError('Value is not in list.')
            ->setFormula1('"Aktif,Tidak Aktif"');

        $writer = new Xlsx($spreadsheet);
        $fileName = 'importdatajenisujian';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
