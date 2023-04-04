<?php

namespace App\Controllers;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Kartuujian extends BaseController
{
    public function index()
    {
        if (date('m') >= 7 and date('m') <= 12) {
            $ajaran = date('Y') . "/" . (date('Y') + 1);
        } elseif (date('m') >= 1 and date('m') <= 6) {
            $ajaran = (date('Y') - 1) . "/" . date('Y');
        }

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
            'datarombel' => $this->rombel->where('npsn', session()->npsn)->find(),
            'ajaran' => $ajaran
        ];

        return view('kartuujian', $data);
    }

    public function checked($rombel, $tingkatan)
    {
        $query = [
            'jenisujian' => $this->db->table('hazedu_jenis_ujian')->where('status', 'Aktif')->get()->getRowArray(),
            'lembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'server' => $this->sp->join('hazedu_server', 'hazedu_server.npsn = hazedu_sp.npsn')->where('hazedu_sp.npsn', session()->npsn)->first(),

            'datasiswa' => $this->pd->where([
                'npsn' => session()->npsn,
                'rombel' => $rombel,
                'tingkatan' => $tingkatan
            ])->orderBy('nama', 'ASC')->find(),

            'tingkatan' => $tingkatan,
            'rombel' => $rombel,
            'pg' => ''
        ];

        foreach ($query['datasiswa'] as $siswa) {
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data("No. Peserta: " . $siswa['no_peserta'] . "\r\nNISN: " . $siswa['nisn'] . "\r\nNama Peserta: " . $siswa['nama'] . "\r\nUsername: " . $siswa['uname'] . "\r\nPassword: " . $siswa['pword'] . "\n\r\n\r\nCopyright 2021 HAz Development")
                ->encoding(new Encoding('UTF-8'))
                ->size(300)
                ->margin(0)
                ->logoPath(realpath(FCPATH . '/assets/dist/img/logo-qr.png'))
                ->logoResizeToHeight(90)
                ->logoResizeToWidth(90)
                // ->logoPunchoutBackground(true)
                ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
                ->build();

            $result->saveToFile('assets/uploads/qrcode/' . session()->npsn . '_' . str_replace(" ", "_", $siswa['nama']) . '.png');
        }

        return view('cetakkartu', $query);
    }

    public function cetak($rombel, $tingkatan)
    {
        $data = [
            'jenisujian' => $this->db->table('hazedu_jenis_ujian')->where('status', 'Aktif')->get()->getRowArray(),
            'lembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'server' => $this->sp->join('hazedu_server', 'hazedu_server.npsn = hazedu_sp.npsn')->where('hazedu_sp.npsn', session()->npsn)->first(),

            'datasiswa' => $this->pd->where([
                'npsn' => session()->npsn,
                'rombel' => $rombel,
                'tingkatan' => $tingkatan
            ])->orderBy('nama', 'ASC')->find(),

            'tingkatan' => $tingkatan,
            'rombel' => $rombel,
            'pg' => 'cetak',
        ];

        return view('cetakkartu', $data);
    }
}
