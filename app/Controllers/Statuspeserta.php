<?php

namespace App\Controllers;

class Statuspeserta extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Status Peserta Ujian',
            'titlecontent' => 'Status Peserta Ujian',
            'breadcrumb' => 'Status Ujian',
            'setting' => $this->apps->first(),
            // 'datasiswa' => $this->pd
            //     ->join('log', 'hazedu_siswa.uid_siswa = log.uid_siswa')
            //     ->join('hazedu_nilai', 'hazedu_siswa.uid_siswa = hazedu_nilai.uid_siswa AND hazedu_nilai.uid_jadwal = log.uid_jadwal')
            //     ->where('hazedu_siswa.npsn', session()->npsn)
            //     ->findAll(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
        ];

        return view('status_peserta', $data);
    }

    public function status()
    {
        $count = $this->jadwal->where([
            'npsn' => session()->npsn,
            'tgl_ujian' => date('Y-m-d'),
            'tgl_expired >=' => date('Y-m-d H:i:s'),
            'status' => 1
        ])->countAllResults();

        $jadwal = $this->jadwal->where([
            'npsn' => session()->npsn,
            'tgl_ujian' => date('Y-m-d'),
            'tgl_expired >=' => date('Y-m-d H:i:s'),
            'status' => 1
        ])->first();


        $nilaiq = $this->pd
            ->join('hazedu_nilai', 'hazedu_nilai.uid_siswa = hazedu_siswa.uid_siswa')
            ->join('log', 'hazedu_siswa.uid_siswa = log.uid_siswa')
            ->where('hazedu_siswa.npsn', session()->npsn)
            ->find();

        $no = "";

        if ($count > 0) {
            foreach ($nilaiq as $status) {
                $no++;

                $data[] = '<div class="col" id="col-' . $status['uid_siswa'] . '">
                            <div class="card card-outline card-primary">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <img id="img-profile" src="' . ($status['foto'] == "" ? '/assets/dist/img/avatar-6.png' : '/assets/uploads/foto/' . $status['foto']) . '" class="img-fluid img-thumbnail img-circle">
                                        </div>
                                        <div class="col">
                                            <ul class="list-group list-group-flush px-0">
                                                <h5 class="card-title fw-bold list-nama">' . $status['nama'] . '</h5>
                                                <li class="list-group-item py-2 px-0 list-tingkatan">' . $status['tingkatan'] . ' / ' . $status['rombel'] . '</li>
                                                <li class="list-group-item py-2 px-0">
                                                    Mulai Ujian: <span class="fw-bold list-startexam">' . date('d-m-Y H:i:s', strtotime($status['ujian_mulai'])) . '</span>
                                                </li>
                                                <li class="list-group-item py-2 px-0">
                                                    IP Address: <span class="fw-bold list-ipaddress">' . $status['ipaddress'] . '</span>
                                                </li>
                                                <h5 class="my-2 card-title fw-bold list-state">' . $status['text'] . '</h5>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-auto text-muted fw-bold align-self-center">Waktu Tersisa</div>
                                        <h5 id="' . $status['uid_siswa'] . '" class="col card-title fw-bold"></h5>
                                    </div>
                                </div>
                            </div>
                        </div>';

                $data[] = [
                    'nomor' => $no,
                    'id_siswa' => $status['uid_siswa'],
                    'nama' => $status['nama'],
                    'tingkatan' => $status['tingkatan'] . ' / ' . $status['rombel'],
                    'startexam' => $status['ujian_mulai'],
                    'formattime' => date('M d, Y H:i:s', strtotime('+' . $jadwal["durasi_ujian"] . 'minutes', strtotime($status['ujian_mulai']))),
                    'finishexam' => $status['ujian_selesai'],
                    'ipaddress' => $status['ipaddress'],
                    'state' => $status['text'],
                    'image' => (empty($status['foto'])) ? '/assets/dist/img/avatar-6.png' : '/assets/uploads/foto/' . $status['foto'],
                ];
            }
            return $this->response->setJSON($data);
        }
    }
}
