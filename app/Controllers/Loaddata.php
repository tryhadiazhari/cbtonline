<?php

namespace App\Controllers;

class Loaddata extends BaseController
{
    public function pengumuman()
    {
        $data = [
            'type' => 'pengumuman',
            'datapengumuman' => $this->loginModel->join('pengumuman', 'pengumuman.user = users.id')->orderBy('pengumuman.date_created', 'DESC')->limit(1)->find(),
        ];

        // dd($data['datapengumuman']);
        return view('loaddata', $data);
    }

    public function log($type = '')
    {
        if ($type == '') {
            if (session()->get('level') == 1) {
                $data = [
                    'type' => 'log',
                    'datalog' => $this->db->query("SELECT * FROM log INNER JOIN siswa ON log.id_siswa = siswa.id_siswa ORDER BY date DESC")->getResult(),
                ];
            } else {
                $data = [
                    'type' => 'log',
                    'datalog' => $this->db->query("SELECT * FROM log INNER JOIN siswa On log.id_siswa = siswa.id_siswa WHERE siswa.npsn = '" . session()->get('username') . "' ORDER BY date DESC")->getResult(),
                ];
            }

            return view('loaddata', $data);
        } else if ($type == 'delete') {
            $msg = [
                'success' => 'sukses',
                'pesan' => 'Log Aktifitas berhasil dibersihkan'
            ];

            echo json_encode($msg);
        }
    }

    public function times()
    {
        echo date('H:i:s');
    }

    public function cektime()
    {
        $jadwal = $this->db->table('hazedu_jadwal')->where([
            'tgl_ujian' =>  date('Y-m-d'),
            'tgl_expired <=' =>  date('Y-m-d 23:59:59'),
        ])->get()->getResultArray();

        if (count($jadwal) > 0) {
            foreach ($jadwal as $val) {
                if ($val['status'] == 0) {
                    $dataa[] = [
                        'status' => 0,
                    ];
                } else {
                    $dataa[] = [
                        'status' => 1,
                    ];
                }
            }
        }

        $data = [
            'data' => (empty($dataa)) ? 0 : $dataa,
            'count' => (empty(count($jadwal))) ? 0 : count($jadwal)
        ];

        return $this->response->setJSON($data);
    }

    public function cekjadwal()
    {
        $jadwal = $this->db->table('hazedu_jadwal')->where([
            'tgl_ujian' =>  date('Y-m-d'),
        ])->get()->getResultArray();

        if (count($jadwal) > 0) {
            foreach ($jadwal as $j => $val) {
                if ($val['status'] == 0) {
                    if ($val['jam_ujian'] == date('H:i:s')) {
                        $this->db->table('hazedu_jadwal')->set('status', 1)->where([
                            'uid_jadwal' => $val['uid_jadwal']
                        ])->update();
                    }
                } else {
                    if (date('Y-m-d H:i:s') == date('Y-m-d 23:59:59')) {
                        $this->db->table('hazedu_jadwal')->set('status', 0)->where([
                            'uid_jadwal' => $val['uid_jadwal']
                        ])->update();
                    }
                }
            }
        }
        // else {
        //         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        // }
    }
}
