<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;

class Api extends BaseController
{
    public function layanan($id = null, $jur = null)
    {
        if ($id) {
            if ($jur) {
            } else {
                $layanan = $this->db->table('jurusan')->where('jenis', $id)->orderBy('jurusan', 'ASC')->get()->getResultArray();

                $array = array();

                foreach ($layanan as $lay) {
                    $data = array();

                    if ($lay['jenis'] == 'PKBM') {
                        if ($lay['jurusan'] != '') {
                            $data['no'] = $lay['uid_jurusan'];
                            $data['jenjang'] = $lay['jenjang'];
                            $data['jurusan'] = $lay['jenjang'];
                            $data['detailsjur'] = $lay['jurusan'];
                        } else {
                            $data['no'] = $lay['uid_jurusan'];
                            $data['jenjang'] = $lay['jenjang'];
                            $data['jurusan'] = '';
                        }
                    } else {
                        $data['no'] = $lay['uid_jurusan'];
                        $data['jenjang'] = $lay['jenjang'];
                        $data['jurusan'] = $lay['jurusan'];
                    }


                    $array[] = $data;
                }

                $response = $array;
            }
        } else {
            $layanan = $this->pendidikan->findAll();
            $array = array();

            foreach ($layanan as $lay) {
                $data = array();
                $data['id'] = $lay['uid_jenjang'];
                $data['jenjang'] = $lay['jenjang'];
                $array[] = $data;
            }

            $response = [
                'jenjang' => $array
            ];
        }

        return $this->response->setJSON($response);
    }

    public function provinsi($id = null)
    {
        if ($id) {
            $data = $this->provinsi->where('id', $id)->orWhere('name', $id)->orderBy('name', 'ASC')->find();
        } else {
            $data = $this->provinsi->orderBy('name', 'ASC')->findAll();
        }
        return $this->response->setJSON($data);
    }

    public function kabupaten($id = null)
    {
        if ($id) {
            $data = $this->kabupaten->where('province_id', $id)->orWhere('name', $id)->orderBy('name', 'ASC')->find();
        } else {
            $data = $this->kabupaten->orderBy('name', 'ASC')->findAll();
        }
        return $this->response->setJSON($data);
    }

    public function kecamatan($id = null)
    {
        if ($id) {
            $data = $this->kecamatan->where('regency_id', $id)->orWhere('name', $id)->orderBy('name', 'ASC')->find();
        } else {
            $data = $this->kecamatan->orderBy('name', 'ASC')->findAll();
        }
        return $this->response->setJSON($data);
    }

    public function kelurahan($id = null)
    {
        if ($id) {
            $data = $this->kelurahan->where('district_id', $id)->orWhere('name', $id)->orderBy('name', 'ASC')->find();
        } else {
            $data = $this->kelurahan->orderBy('name', 'ASC')->findAll();
        }
        return $this->response->setJSON($data);
    }

    public function jenjang($id = null)
    {
        if ($id) {
            $cekdata = $this->sp->where('npsn', $id)->first();

            if ($cekdata['jenis'] == 'SD' || $cekdata['jenis'] == 'SMP') {
                $response[] = [
                    'npsn' => $cekdata['npsn'],
                    'jenjang' => $cekdata['jenis']
                ];
            } else {
                $layanan = $this->db->table('hazedu_sp_jenjang')->where('npsn', session()->npsn)->orderBy('jenjang', 'ASC')->get()->getResultArray();

                $array = array();
                $no = 0;
                foreach ($layanan as $nomor => $value) {
                    $no++;

                    $data = array();
                    $data['nomor'] = $nomor + 1;
                    $data['npsn'] = $value['npsn'];
                    $data['jenjang'] = $value['jenjang'];
                    $array[] = $data;
                }

                $response = $array;
            }
        } else {
            $layanan = $this->db->table('hazedu_jenjang')->orderBy('uid_jenjang', 'ASC')->get()->getResultArray();

            $array = array();

            foreach ($layanan as $lay) {
                $data = array();
                $data['id'] = $lay['uid_jenjang'];
                $data['jenjang'] = $lay['jenjang'];
                $array[] = $data;
            }

            $response = $array;
        }
        return $this->response->setJSON($response);
    }

    public function tingkatan($id = null)
    {
        if ($id) {
            $delimiters = [' IPA', ' IPS', ' Bahasa'];

            $explode = str_replace($delimiters, $delimiters[1], $id);
            $arr = explode($delimiters[1], $explode);

            $jurusan = $this->db->table('jurusan')->where('jenjang', $id)->orWhere('jurusan', $id)->get();
            $resultJurusan = $jurusan->getResultArray();
            $queryJurusan = $jurusan->getRowArray();

            if (count($resultJurusan) > 0) {
                $layanan = $this->db->table('tingkatan')->orderBy('tingkatan', 'ASC')->get()->getResultArray();

                $array = array();
                foreach ($layanan as $lay) {
                    $data = array();
                    $explodeNew = explode(', ', $lay['jenjang']);

                    if ($arr[0] == 'Paket C') {
                        if ($explodeNew[1] == 'SMK') {
                            $data['jenjang'] = $queryJurusan['jenjang'];
                            $data['tingkatan'] = $lay['tingkatan'];
                            $array[] = $data;
                        }
                    }

                    if ($queryJurusan['jenjang'] == $explodeNew[0] || $queryJurusan['jenjang'] == $explodeNew[1]) {
                        $data['jenjang'] = $queryJurusan['jenjang'];
                        $data['tingkatan'] = $lay['tingkatan'];
                        $array[] = $data;
                    }
                }

                return $this->response->setJSON($array);
            } else {
                $layanan = $this->db->table('tingkatan')->orderBy('tingkatan', 'ASC')->get()->getResultArray();

                $array = array();
                foreach ($layanan as $lay) {
                    $data = array();

                    $explodeNew = explode(', ', $lay['jenjang']);

                    if ($explodeNew[0] == $id) {
                        $data['jenjang'] = $explode;
                        $data['tingkatan'] = $lay['tingkatan'];

                        $array[] = $data;
                    }
                }

                return $this->response->setJSON($array);
            }
        } else {
            $layanan = $this->db->table('tingkatan')->orderBy('tingkatan', 'ASC')->get()->getResultArray();

            $array = array();

            foreach ($layanan as $lay) {
                $data = array();
                $data['id'] = $lay['id'];
                $data['tingkatan'] = $lay['tingkatan'];
                $data['jenjang'] = $lay['jenjang'];
                $array[] = $data;
            }

            return $this->response->setJSON($array);
        }
    }

    public function jurusan($id = null)
    {
        if ($id) {
            $jurusan = $this->db->table('jurusan')->where('jenjang', $id)->orderBy('jurusan', 'ASC')->get()->getResultArray();

            $array = array();

            foreach ($jurusan as $jur) {
                $data = array();
                $data['jurusan'] = $jur['jurusan'];
                $array[] = $data;

                $response = $array;
            }
        } else {
            $jurusan = $this->db->table('jurusan')->orderBy('jurusan', 'ASC')->get()->getResultArray();

            $array = array();

            foreach ($jurusan as $jur) {
                $data = array();
                $data['jenjang'] = $jur['jenjang'];
                $data['jurusan'] = $jur['jurusan'];
                $array[] = $data;

                $response = $array;
            }
        }
        return $this->response->setJSON($response);
    }

    public function kurikulum($jurusan = null, $tingkatan = null)
    {
        if ($jurusan) {
            $data = $this->db->table('kurikulum')->where('jurusan', $jurusan)->get();

            $count  = $data->getResultArray();

            if (count($count) > 0) {
                $dd = $data->getRowArray();
                $explode = explode(', ', $dd['tingkatan']);

                if ($explode[0] == $tingkatan) {
                    $response = [
                        'kurikulum' => $dd['kurikulum']
                    ];
                } else {
                    $response = [
                        'kurikulum' => $dd['kurikulum']
                    ];
                }
            } else {
                $response = ['kurikulum' => 'Kurikulum 2013'];
            }

            return $this->response->setJSON($response);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Ups... Anda mau coba cari data ya!!!');
        }
    }

    public function rombel($tingkatan = null, $jenjang = null)
    {
        if ($tingkatan) {
            $jurusan = $this->rombel->where([
                'npsn' => session()->npsn,
                'tingkatan' => $tingkatan,
                'jenjang' => $jenjang
            ])->find();

            if (count($jurusan) > 0) {
                foreach ($jurusan as $jur) {
                    $data[] = [
                        'jenjang' => $jur['jenjang'],
                        'tingkatan' => $jur['tingkatan'],
                        'romble' => $jur['nama'],
                    ];
                }
                return $this->response->setJSON($data);
            }
        }
    }

    public function gtk($id)
    {
        $datagtk = $this->gtk->where('npsn', $id)->findAll();

        return $this->response->setJSON($datagtk);
    }

    public function pd($npsn = null, $rombel = null)
    {
        if ($npsn) {
            if ($rombel) {
                $datasiswa = $this->pd->where([
                    'npsn' => $npsn,
                    'rombel' => $rombel
                ])->findAll();

                $array = array();

                foreach ($datasiswa as $val) {
                    $data = array();

                    $data['id'] = $val['uid_siswa'];
                    $data['nama'] = $val['nama'];
                    $data['tanggal_lahir'] = $val['tanggal_lahir'];
                    $data['agama'] = $val['agama'];
                    $data['rombel'] = $val['rombel'];
                    $data['nisn'] = $val['nisn'];
                    $data['nis'] = $val['nis'];
                    $data['jenis'] = $val['jenis_daftar'];

                    $array[] = $data;
                }

                $response = [
                    'data' => $array
                ];
            } else {
                $datasiswa = $this->pd->where([
                    'npsn' => $npsn,
                    'rombel' => ''
                ])->findAll();

                $array = array();

                foreach ($datasiswa as $val) {
                    $data = array();

                    $data['id'] = $val['uid_siswa'];
                    $data['nama'] = $val['nama'];
                    $data['tanggal_lahir'] = $val['tanggal_lahir'];
                    $data['agama'] = $val['agama'];
                    $data['rombel'] = $val['rombel'];
                    $data['nisn'] = $val['nisn'];
                    $data['nis'] = $val['nis'];
                    $data['jenis'] = "";

                    $array[] = $data;
                }

                $response = [
                    'data' => $array
                ];
            }
        } else {
            $datasiswa = $this->pd->findAll();

            $array = array();

            foreach ($datasiswa as $val) {
                $data = array();

                $data['id'] = $val['uid_siswa'];
                $data['nama'] = $val['nama'];
                $data['tanggal_lahir'] = $val['tanggal_lahir'];
                $data['agama'] = $val['agama'];
                $data['rombel'] = $val['rombel'];
                $data['nisn'] = $val['nisn'];
                $data['nis'] = $val['nis'];
                $data['jenis'] = "";

                $array[] = $data;
            }

            $response = [
                'data' => $array
            ];
        }

        return $this->response->setJSON($response);
    }

    public function religion()
    {
        $dataagama = $this->db->table('hazedu_agama')->orderBy('id', 'ASC')->get()->getResultArray();

        foreach ($dataagama as $agama) {
            $data[] = [
                'agama' => $agama['agama']
            ];
        }

        return $this->response->setJSON($data);
    }

    public function banksoal($jenjang, $tingkatan, $rombel = null)
    {
        $query = $this->banksoal->where([
            'npsn' => session()->npsn,
            'jenjang' => $jenjang,
            'tingkatan' => $tingkatan,
            'status' => 1
        ])->orderBy('created_date', 'ASC')->findAll();

        foreach ($query as $nomor => $value) {
            $data[] = [
                'npsn' => $value['npsn'],
                'kode' => str_replace('BS-', '', $value['uid_banksoal']),
                'mapel' => ($value['kategori'] != '') ? $value['mapel'] . ' ' . $value['kategori'] : $value['mapel'],
            ];
        }

        return $this->response->setJSON($data);
    }

    public function soal($id, $jenis, $nomor)
    {
        if ($jenis == 1) {
            $data = [
                'mapel' => $this->banksoal->where('uid_banksoal', $id)->first(),
                'datasoal' => $this->soal->where('uid_banksoal', $id)->find(),
            ];

            $soal = $this->soal->where('uid_banksoal', $id)->where('nomor', $nomor)->where('jenis', $jenis)->first();
            $count = $this->soal->where('uid_banksoal', $id)->where('nomor', $nomor)->where('jenis', $jenis)->find();

            $array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];

            for ($i = 1; $i <= $data['mapel']['opsi']; $i++) {
                $opsi[] = [
                    'pil' . $array[$i] => (count($count) > 0) ? $soal['pil' . $array[$i]] : ''
                ];
                $file[] = [
                    'file' . $array[$i] => (count($count) > 0) ? $soal['file' . $array[$i]] : ''
                ];
            }

            return $this->response->setJSON([
                "idsoal" => (count($count) > 0) ? $soal['uid_soal'] : '',
                "npsn" => session()->npsn,
                "idbanksoal" => $id,
                "kodemapel" => $data['mapel']['kode_mapel'],
                "mapel" => $data['mapel']['mapel'],
                "alias" => $data['mapel']['alias'],
                "kategori" => ($data['mapel']['kategori'] == '') ? '' : $data['mapel']['kategori'],
                "guru" => $data['mapel']['gtk'],
                "nomor" => $nomor,
                "soal" => (count($count) > 0) ? $soal['soal'] : '',
                "jenis" => 1,
                // "pilA" => (count($count) > 0) ? $soal['pilA'] : '',
                // "pilB" => (count($count) > 0) ? $soal['pilB'] : '',
                // "pilC" => (count($count) > 0) ? $soal['pilC'] : '',
                // "pilD" => (count($count) > 0) ? $soal['pilD'] : '',
                // "pilE" => (count($count) > 0) ? $soal['pilE'] : '',
                'opsi' => $opsi,
                "kunci" => (count($count) > 0) ? $soal['jawaban'] : '',
                "essay" => (count($count) > 0) ? $soal['jawaban_essay'] : '',
                "faudio" => (count($count) > 0) ? $soal['file_audio'] : '',
                "paketsoal" => (count($count) > 0) ? $soal['paket_soal'] : '',
                "jenjang" => (count($count) > 0) ? $soal['jenjang'] : '',
                "jurusan" => (count($count) > 0) ? $soal['jurusan'] : '',
                "tingkatan" => (count($count) > 0) ? $soal['tingkatan'] : '',
                "rombel" => (count($count) > 0) ? $soal['rombel'] : '',
                'file' => $file,
            ]);
        } else {
            $data = [
                'mapel' => $this->banksoal->where('uid_banksoal', $id)->first(),
                'datasoal' => $this->soal->where('uid_banksoal', $id)->find(),
            ];

            $soal = $this->soal->where('uid_banksoal', $id)->where('nomor', $nomor)->where('jenis', $jenis)->first();
            $count = $this->soal->where('uid_banksoal', $id)->where('nomor', $nomor)->where('jenis', $jenis)->find();

            $array = [1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E'];

            for ($i = 1; $i <= $data['mapel']['opsi']; $i++) {
                $opsi[] = [
                    'pil' . $array[$i] => (count($count) > 0) ? $soal['pil' . $array[$i]] : ''
                ];
                $file[] = [
                    'file' . $array[$i] => (count($count) > 0) ? $soal['file' . $array[$i]] : ''
                ];
            }

            return $this->response->setJSON([
                "idsoal" => (count($count) > 0) ? $soal['uid_soal'] : '',
                "npsn" => session()->npsn,
                "idbanksoal" => $id,
                "kodemapel" => $data['mapel']['kode_mapel'],
                "mapel" => $data['mapel']['mapel'],
                "alias" => $data['mapel']['alias'],
                "kategori" => ($data['mapel']['kategori'] == '') ? '' : $data['mapel']['kategori'],
                "guru" => $data['mapel']['gtk'],
                "nomor" => $nomor,
                "soal" => (count($count) > 0) ? $soal['soal'] : '',
                "jenis" => 2,
                "faudio" => (count($count) > 0) ? $soal['file_audio'] : '',
                "paketsoal" => (count($count) > 0) ? $soal['paket_soal'] : '',
                "jenjang" => (count($count) > 0) ? $soal['jenjang'] : '',
                "jurusan" => (count($count) > 0) ? $soal['jurusan'] : '',
                "tingkatan" => (count($count) > 0) ? $soal['tingkatan'] : '',
                "rombel" => (count($count) > 0) ? $soal['rombel'] : '',
                'file' => $file,
            ]);
        }
    }

    public function test($id, $jenis, $nomor)
    {
        $cek = $this->soal->where('uid_banksoal', $id)->where('nomor', $nomor)->where('jenis', $jenis)->first();

        dd($cek['file_audio']);
    }
}
