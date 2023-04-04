<?php

namespace App\Controllers;

use DOMDocument;

class ImportSoal extends BaseController
{
    public function index($id)
    {
        $data = [
            'title' => 'Bank Soal | Import Soal',
            'titlecontent' => 'Import Soal ',
            'breadcrumb' => 'Import Soal ',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'mapel' => $this->banksoal->where('uid_banksoal', $id)->first(),
            'soalpg' => $this->soal->where([
                'uid_banksoal' => $id,
                'jenis' => 1
            ])->orderBy('nomor', 'ASC')->find(),
            'soalessay' => $this->soal->where([
                'uid_banksoal' => $id,
                'jenis' => 2
            ])->orderBy('nomor', 'ASC')->find(),
        ];

        return view('banksoal/importsoal', $data);
    }

    public function import($id)
    {
        $data = $this->request->getPost('importsoal');
        $validate = $this->validate([
            'importsoal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Data tidak boleh kosong...'
                ]
            ],
        ]);
        $error = $this->validation->getError();

        if ($error) {
            return $this->response->setJSON($error)->setStatusCode(404);
        } else {
            $doc = new DOMDocument();
            $doc->loadHTML($data);
            $tables = $doc->getElementsByTagName('table');
            if (!empty($tables->item(0)->nodeValue)) {
                $rows = $tables->item(0)->getElementsByTagName('tr');
                $counter = 1;
                $soal = '<table border="0" width="100%" class="no-padding" class="table-condensed">';
                foreach ($rows as $row) {
                    /*** get each column by tag name ***/
                    $cols = $row->getElementsByTagName('td');
                    $kosong = 0;

                    if (empty($cols->item(1)->nodeValue)) {
                        $kosong++;
                    }

                    if (empty($cols->item(2)->nodeValue)) {
                        $kosong++;
                    }

                    if (empty($cols->item(3)->nodeValue)) {
                        $kosong++;
                    }
                    if ($kosong == 0) {
                        $jenis = strtoupper(preg_replace('/\s+/', '', $cols->item(1)->nodeValue));
                        $kunci = strtoupper(preg_replace('/\s+/', '', $cols->item(3)->nodeValue));
                        $kunci = intval($kunci);
                        if ($kunci > 1) {
                            $kunci = 1;
                        }
                        if ($jenis == 'SOAL') {
                            $soal = $soal . '
								<tr>
								<td valign="top"><p>' . $counter . '</p></td>
								<td colspan="2">' . $cols->item(2)->nodeName . '</td>
								<td width="15%"></td>
								</tr>
							';
                            $counter++;
                        } else if ($jenis == 'JAWABAN') {
                            $soal = $soal . '
									<tr>
										<td width="5%"> </td>
										<td width="5%" valign="top">' . $kunci . '</td>
										<td width="75%">' . $cols->item(2) . '</td>
										<td width="15%"></td>
									</tr>
								';
                        }
                    } else {
                        // menghentikan loop ketika ada yang kosong
                        break;
                    }
                }
                $soal = $soal . '</table>';

                if ($counter > 1) {
                    $status['soal'] = $soal;
                    $status['status'] = 1;
                    $status['pesan'] = '';
                } else {
                    $status['status'] = 0;
                    $status['pesan'] = 'Silahkan cek format soal terlebih dahulu';
                }
            } else {
                $status['status'] = 0;
                $status['pesan'] = 'Terjadi kesalahan format soal. Silahkan cek format soal terlebih dahulu';
            }

            return $this->response->setJSON($status);
        }
    }
}
