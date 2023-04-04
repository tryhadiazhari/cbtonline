<?php

namespace App\Controllers;

class Soalessai extends BaseController
{
    public function essay($id, $jenis, $nomor)
    {
        $data = [
            'title' => 'Bank Soal | Soal',
            'titlecontent' => 'Soal ',
            'breadcrumb' => 'Soal ',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'mapel' => $this->banksoal->where('uid_banksoal', $id)->first(),
            'datasoal' => $this->soal->where('uid_banksoal', $id)->find(),
            'soal' => $this->soal->where('uid_banksoal', $id)->where('nomor', $nomor)->where('jenis', $jenis)->first(),
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

        return view('banksoal/inputsoalessai', $data);
    }

    public function save($id, $jenis, $nomor)
    {
        $post = $this->request->getPost();
        $nomor = $post['nomor'];

        $data = [
            'title' => 'Bank Soal | Soal Essay',
            'titlecontent' => 'Soal ',
            'breadcrumb' => 'Soal ',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'mapel' => $this->banksoal->where('uid_banksoal', $id)->first(),
            'datasoal' => $this->soal->where('uid_banksoal', $id)->find(),
            'soal' => $this->soal->where([
                'uid_banksoal' => $id,
                'nomor' => $nomor,
                'jenis' => 2
            ])->first(),
            'countdata' => $this->soal->where([
                'uid_banksoal' => $id,
                'nomor' => $nomor,
                'jenis' => 2
            ])->find(),
        ];

        $uid = str_replace('BS-', '', $id);

        $filesuara = $this->request->getFile('file');
        $filename = $filesuara->getRandomName();

        if ($filesuara == '') {
            $insert = [
                'uid_soal' => $uid . $jenis . $nomor . $data['mapel']['jurusan'],
                'npsn' => session()->npsn,
                'uid_banksoal' => $id,
                'kode_mapel' => $data['mapel']['kode_mapel'],
                'mapel' => $data['mapel']['mapel'],
                'alias' => $data['mapel']['alias'],
                'kategori' => $data['mapel']['kategori'],
                'gtk' => $data['mapel']['gtk'],
                'nomor' => $nomor,
                'soal' => $post['soal'],
                'jenis' => 2,
                'paket_soal' => $data['mapel']['paket_soal'],
                'jenjang' => $data['mapel']['jenjang'],
                'jurusan' => $data['mapel']['jurusan'],
                'tingkatan' => $data['mapel']['tingkatan'],
                'rombel' => (empty($data['mapel']['rombel'])) ? '' : $data['mapel']['rombel'],
            ];
        } else {
            $insert = [
                'uid_soal' => $uid . $jenis . $nomor . $data['mapel']['jurusan'],
                'npsn' => session()->npsn,
                'uid_banksoal' => $id,
                'kode_mapel' => $data['mapel']['kode_mapel'],
                'mapel' => $data['mapel']['mapel'],
                'alias' => $data['mapel']['alias'],
                'kategori' => $data['mapel']['kategori'],
                'gtk' => $data['mapel']['gtk'],
                'nomor' => $nomor,
                'soal' => $post['soal'],
                'jenis' => 2,
                'file_audio' => count($data['countdata']) > 0 ? ($data['soal']['file_audio'] == '' ? $filename : $data['soal']['file_audio']) : $filename,
                'paket_soal' => $data['mapel']['paket_soal'],
                'jenjang' => $data['mapel']['jenjang'],
                'jurusan' => $data['mapel']['jurusan'],
                'tingkatan' => $data['mapel']['tingkatan'],
                'rombel' => (empty($data['mapel']['rombel'])) ? '' : $data['mapel']['rombel'],
            ];

            if ($filesuara->isValid() && !$filesuara->hasMoved()) {
                if (count($data['countdata']) > 0) {
                    if ($data['soal']['file_audio'] == "") {
                        $filesuara->move('assets/uploads/audio/', $filename);
                    } else {
                        unlink('assets/uploads/audio/' . $data['soal']['file_audio']);
                        $filesuara->move('assets/uploads/audio/', $filename);
                    }
                } else {
                    $filesuara->move('assets/uploads/audio/', $filename);
                }
            }
        }

        if ($this->soal->save($insert)) {
            return $this->response->setJSON([
                'success' => 'Data berhasil disimpan',
            ]);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal disimpan'])->setStatusCode(400);
        }
    }

    public function deletesoal($id)
    {
        $query = $this->soal->where('uid_soal', $id)->first();
        $data = $this->banksoal->where('uid_banksoal', $query['uid_banksoal'])->first();

        $array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];

        if ($query['file_audio'] != '') {
            $deletefolder = unlink('assets/uploads/audio/' . $query['file_audio']);
        }

        for ($i = 1; $i <= $data['opsi']; $i++) {
            if ($query['file' . $array[$i]] != '') {
                $file[] = unlink('assets/uploads/audio/' . $query['file' . $array[$i]]);
            }
        }

        if ($this->soal->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus'])->setStatusCode(400);
        }
    }

    public function deleteall($id)
    {
        $query = $this->soal->where('uid_banksoal', $id)->find();
        $data = $this->banksoal->where('uid_banksoal', $id)->first();

        foreach ($query as $val) {
            if ($val['file_audio'] != '') {
                $deletefolder[] = unlink('assets/uploads/audio/' . $val['file_audio']);
            }

            $array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];

            for ($i = 1; $i <= $data['opsi']; $i++) {
                if ($val['file' . $array[$i]] != '') {
                    $file[] = unlink('assets/uploads/audio/' . $val['file' . $array[$i]]);
                }
            }
        }

        if ($this->soal->where('uid_banksoal', $id)->delete()) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus'])->setStatusCode(400);
        }
    }
}
