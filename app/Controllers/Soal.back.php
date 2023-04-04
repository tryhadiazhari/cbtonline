<?php

namespace App\Controllers;

class Soal extends BaseController
{
    public function index($id, $jenis = null, $nomor = null)
    {
        $data = [
            'title' => 'Bank Soal | Soal',
            'titlecontent' => 'Soal ',
            'breadcrumb' => 'Soal ',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'mapel' => $this->banksoal->join('hazedu_pembelajaran', 'hazedu_banksoal.kode_mapel = hazedu_pembelajaran.kode_mapel', 'inner')->where('hazedu_banksoal.uid_banksoal', $id)->first(),
            'soalpg' => $this->soal->where([
                'uid_banksoal' => $id,
                'tipe' => 1
            ])->orderBy('nomor', 'ASC')->find(),
            'soalessay' => $this->soal->where([
                'uid_banksoal' => $id,
                'tipe' => 2
            ])->orderBy('nomor', 'ASC')->find(),
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

        return view('banksoal/soal', $data);
    }

    public function form($id, $tipe, $nomor)
    {
        $data = [
            'title' => 'Bank Soal | Soal',
            'titlecontent' => 'Soal ',
            'breadcrumb' => 'Soal ',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'mapel' => $this->banksoal->join('hazedu_pembelajaran', 'hazedu_banksoal.kode_mapel = hazedu_pembelajaran.kode_mapel', 'inner')->where('uid_banksoal', $id)->first(),
            'datasoal' => $this->soal->where('uid_banksoal', $id)->find(),
            'soal' => $this->soal->where([
                'uid_banksoal' => $id,
                'tipe' => $tipe,
                'nomor' => $nomor,
            ])->first(),
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

        if ($tipe == 1 || $tipe == 2) {
            return view('banksoal/inputsoal', $data);
        } else if ($tipe == 3) {
            return view('banksoal/inputsoal3', $data);
        } else if ($tipe == 4) {
            return view('banksoal/inputsoal4', $data);
        } else if ($tipe == 5) {
            return view('banksoal/inputsoal5', $data);
        } else if ($tipe == 6) {
            return view('banksoal/inputsoal6', $data);
        } else if ($tipe == 7) {
            return view('banksoal/inputsoal7', $data);
        } else if ($tipe == 8) {
            return view('banksoal/inputsoal8', $data);
        }
    }

    public function save($id, $jenis, $nomor)
    {
        $post = $this->request->getPost();
        $nomor = $post['nomor'];

        $data = [
            'title' => 'Bank Soal | Soal',
            'titlecontent' => 'Soal ',
            'breadcrumb' => 'Soal ',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'mapel' => $this->banksoal->where('uid_banksoal', $id)->first(),
            'datasoal' => $this->soal->where('uid_banksoal', $id)->find(),
            'soal' => $this->soal->where([
                'uid_banksoal' => $id,
                'nomor' => $nomor,
                'jenis' => $jenis
            ])->first(),
            'countdata' => $this->soal->where([
                'uid_banksoal' => $id,
                'nomor' => $nomor,
                'jenis' => $jenis
            ])->find(),
        ];

        $uid = str_replace('BS-', '', $id);

        $filesuara = $this->request->getFile('file');
        $filename = $filesuara->getRandomName();

        $fileA = $this->request->getFile('fileA');

        $fileB = $this->request->getFile('fileB');

        $fileC = $this->request->getFile('fileC');

        $fileD = $this->request->getFile('fileD');

        $fileE = $this->request->getFile('fileE');

        $file = new \CodeIgniter\Files\File('assets/uploads/audio/');

        if ($filesuara == '') {
            // unlink('assets/uploads/audio/' . $data['soal']['file_audio']);
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
                'jenis' => $jenis,
                'pilA' => ($post['pilA'] == '') ? '' : $post['pilA'],
                'pilB' => (empty($post['pilB'])) ? '' : $post['pilB'],
                'pilC' => (empty($post['pilC'])) ? '' : $post['pilC'],
                'pilD' => ($data['mapel']['opsi'] == 4 || $data['mapel']['opsi'] == 5) ? (empty($post['pilD']) ? '' : $post['pilD']) : '',
                'pilE' => ($data['mapel']['opsi'] == 5) ? (empty($post['pilE']) ? '' : $post['pilE']) : '',
                'jawaban' => (empty($post['jawaban']) ? '' : $post['jawaban']),
                'jawaban_essay' => '',
                'fileA' => ($fileA == '') ? (count($data['countdata']) > 0 ? $data['soal']['fileA'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension(),
                'fileB' => ($fileB == '') ? (count($data['countdata']) > 0 ? $data['soal']['fileB'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension(),
                'fileC' => ($fileC == '') ? (count($data['countdata']) > 0 ? $data['soal']['fileC'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension(),
                'fileD' => $data['mapel']['opsi'] == 4 || $data['mapel']['opsi'] == 5 ? ($fileD == '' ? (count($data['countdata']) > 0 ? $data['soal']['fileD'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension()) : '',
                'fileE' => $data['mapel']['opsi'] == 5 ? ($fileE == '' ? (count($data['countdata']) > 0 ? $data['soal']['fileE'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension()) : '',
                'paket_soal' => $data['mapel']['paket_soal'],
                'jenjang' => $data['mapel']['jenjang'],
                'jurusan' => $data['mapel']['jurusan'],
                'tingkatan' => $data['mapel']['tingkatan'],
                'rombel' => (empty($data['mapel']['rombel'])) ? '' : $data['mapel']['rombel'],
            ];

            if ($fileA->isValid() && !$fileA->hasMoved()) {
                if (count($data['countdata']) > 0) {
                    if ($data['soal']['fileA'] == "") {
                        $fileA->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension());
                    } else {
                        unlink('assets/uploads/audio/' . $data['soal']['fileA']);
                        $fileA->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension());
                    }
                } else {
                    $fileA->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension());
                }
            }
            if ($fileB->isValid() && !$fileB->hasMoved()) {
                if (count($data['countdata']) > 0) {
                    if ($data['soal']['fileB'] == "") {
                        $fileB->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension());
                    } else {
                        unlink('assets/uploads/audio/' . $data['soal']['fileB']);
                        $fileB->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension());
                    }
                } else {
                    $fileB->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension());
                }
            }

            if ($data['mapel']['opsi'] == 3 || $data['mapel']['opsi'] == 4) {
                if ($fileC->isValid() && !$fileC->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileC'] == "") {
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileC']);
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        }
                    } else {
                        $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                    }
                }
            }
            if ($data['mapel']['opsi'] == 4 || $data['mapel']['opsi'] == 5) {
                if ($fileD->isValid() && !$fileD->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileD'] == "") {
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileD']);
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        }
                    } else {
                        $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                    }
                }
            }
            if ($data['mapel']['opsi'] == 5) {
                if ($fileC->isValid() && !$fileC->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileC'] == "") {
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileC']);
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        }
                    } else {
                        $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                    }
                }
                if ($fileD->isValid() && !$fileD->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileD'] == "") {
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileD']);
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        }
                    } else {
                        $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                    }
                }
                if ($fileE->isValid() && !$fileE->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileE'] == "") {
                            $fileE->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileE']);
                            $fileE->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension());
                        }
                    } else {
                        $fileE->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension());
                    }
                }
            }
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
                'jenis' => $jenis,
                'pilA' => $post['pilA'],
                'pilB' => $post['pilB'],
                'pilC' => $post['pilC'],
                'pilD' => ($data['mapel']['opsi'] == 4 || $data['mapel']['opsi'] == 5) ? $post['pilD'] : '',
                'pilE' => ($data['mapel']['opsi'] == 5) ? $post['pilE'] : '',
                'jawaban' => $post['jawaban'],
                'jawaban_essay' => '',
                'file_audio' => count($data['countdata']) > 0 ? ($data['soal']['file_audio'] == '' ? $filename : $data['soal']['file_audio']) : $filename,
                'fileA' => ($fileA == '') ? (count($data['countdata']) > 0 ? $data['soal']['fileA'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension(),
                'fileB' => ($fileB == '') ? (count($data['countdata']) > 0 ? $data['soal']['fileB'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension(),
                'fileC' => ($fileC == '') ? (count($data['countdata']) > 0 ? $data['soal']['fileC'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension(),
                'fileD' => $data['mapel']['opsi'] == 4 || $data['mapel']['opsi'] == 5 ? ($fileD == '' ? (count($data['countdata']) > 0 ? $data['soal']['fileD'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension()) : '',
                'fileE' => $data['mapel']['opsi'] == 5 ? ($fileE == '' ? (count($data['countdata']) > 0 ? $data['soal']['fileE'] : '') : str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension()) : '',
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

            if ($fileA->isValid() && !$fileA->hasMoved()) {
                if (count($data['countdata']) > 0) {
                    if ($data['soal']['fileA'] == "") {
                        $fileA->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension());
                    } else {
                        unlink('assets/uploads/audio/' . $data['soal']['fileA']);
                        $fileA->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension());
                    }
                } else {
                    $fileA->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'A' . $jenis . $nomor . '.' . $fileA->getClientExtension());
                }
            }
            if ($fileB->isValid() && !$fileB->hasMoved()) {
                if (count($data['countdata']) > 0) {
                    if ($data['soal']['fileB'] == "") {
                        $fileB->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension());
                    } else {
                        unlink('assets/uploads/audio/' . $data['soal']['fileB']);
                        $fileB->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension());
                    }
                } else {
                    $fileB->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'B' . $jenis . $nomor . '.' . $fileB->getClientExtension());
                }
            }

            if ($data['mapel']['opsi'] == 3 || $data['mapel']['opsi'] == 4) {
                if ($fileC->isValid() && !$fileC->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileC'] == "") {
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileC']);
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        }
                    } else {
                        $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                    }
                }
            }
            if ($data['mapel']['opsi'] == 4 || $data['mapel']['opsi'] == 5) {
                if ($fileD->isValid() && !$fileD->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileD'] == "") {
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileD']);
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        }
                    } else {
                        $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                    }
                }
            }
            if ($data['mapel']['opsi'] == 5) {
                if ($fileC->isValid() && !$fileC->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileC'] == "") {
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileC']);
                            $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                        }
                    } else {
                        $fileC->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'C' . $jenis . $nomor . '.' . $fileC->getClientExtension());
                    }
                }
                if ($fileD->isValid() && !$fileD->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileD'] == "") {
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileD']);
                            $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                        }
                    } else {
                        $fileD->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'D' . $jenis . $nomor . '.' . $fileD->getClientExtension());
                    }
                }
                if ($fileE->isValid() && !$fileE->hasMoved()) {
                    if (count($data['countdata']) > 0) {
                        if ($data['soal']['fileE'] == "") {
                            $fileE->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension());
                        } else {
                            unlink('assets/uploads/audio/' . $data['soal']['fileE']);
                            $fileE->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension());
                        }
                    } else {
                        $fileE->move('assets/uploads/audio/', str_replace('BS-', '', $id) . '_' . date('Ymd') . time() . 'E' . $jenis . $nomor . '.' . $fileE->getClientExtension());
                    }
                }
            }
        }

        if ($this->soal->save($insert)) {
            return $this->response->setJSON([
                'success' => 'Data berhasil disimpan',
                'file' => $file->getRealPath()
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

    public function ceksoal($id)
    {
        $query = $this->soal->where('uid_banksoal', $id)->find();

        if (count($query) == 0) {
            return $this->response->setJSON(['nomor' => 1]);
        }
    }
}
