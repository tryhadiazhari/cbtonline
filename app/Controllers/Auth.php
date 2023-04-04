<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $login;
    public function __construct()
    {
        function getUserIpAddr()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                //ip from share internet
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                //ip pass from proxy
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
    }

    public function index()
    {
        $query = $this->apps->first();

        $data = [
            'title' => 'Login | ' . $query['appname'],
            'subtitle' => $query['appname'],
            'developer' => $query['developer']
        ];
        return view('auth/login', $data);
    }

    public function ceklogin()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'valid');
        $getErrors = $this->validation->getErrors();

        if ($getErrors) {
            return $this->response->setJSON($getErrors)->setStatusCode(404);
        } else {
            $login = $this->login->where('uname', $data['username'])->get();
            $result = $login->getResult();
            $row = $login->getRow();

            if (count($result) > 0) {
                if (password_verify($data['password'], $row->pword)) {
                    if ($row->is_activated == 1) {
                        $session = [
                            'uid' => $row->uid,
                            'npsn' => $row->npsn,
                            'uname' => $row->uname,
                            'fname' => $row->fname,
                            'lv' => $row->lv,
                        ];

                        session()->set($session);
                    } else {
                        return $this->response->setJSON(['errors' => 'Akun belum aktif, silahkan aktifasi dahulu ya...'])->setStatusCode(400);
                    }

                    return $this->response->setJSON(['success' => 'Login Berhasil...']);
                } else {
                    return $this->response->setJSON(['errors' => 'Password Anda salah!!!'])->setStatusCode(400);
                }
            } else {
                return $this->response->setJSON(['errors' => 'Username <strong><i>' . $data['username'] . '</i></strong> tidak tersedia!!!'])->setStatusCode(400);
            }
        }
    }

    public function logout()
    {
        session()->destroy();

        // $this->db->table('log_users')->where('npsn', session()->get('username'))->update(array(
        //     'date_out' => date('Y-m-d H:i:s'),
        // ));

        return redirect()->to('/auth');
    }

    public function verification()
    {
        $token = $this->request->getGet('token');

        $builder = $this->db->table('hazedu_users_token')->where('token', $token)->get();
        $result = $builder->getRowArray();

        // dd($result['email']);

        if (count($builder->getResult()) == 1) {
            $cekUser = $this->login->where('eml', $result['email'])->first();
            $cekServer = $this->db->table('hazedu_server')->where('npsn', $cekUser['npsn'])->get();

            if ($cekUser['is_activated'] == 0) {
                $update = $this->login->set([
                    'activation_date' => date('Y-m-d H:i:s'),
                    'is_activated' => 1
                ])->where('eml', $result['email'])->update();
                $update2 = $this->sp->set([
                    'activation_date' => date('Y-m-d H:i:s'),
                    'is_activated' => 1
                ])->where('npsn', $result['username'])->update();

                if ($update && $update2) {
                    if (count($cekServer->getResult()) == 0) {
                        $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                        $server = $this->db->table('hazedu_server')->insert([
                            'kode_server' => 'HAZEDU' . $cekUser['npsn'] . 'CBT',
                            'npsn'  => $cekUser['npsn'],
                            'nama_server'  => gethostbyaddr($_SERVER['REMOTE_ADDR']),
                            'ip_address'  => $_SERVER['REMOTE_ADDR'],
                            'status' => 'Offline'
                        ]);

                        session()->setFlashdata('success', 'Aktifasi akun berhasil... Silahkan Login');
                        return redirect()->to('/auth');
                    } else {
                        session()->setFlashData('error', 'Aktifasi akun gagal... Akun sudah aktif!');
                        return redirect()->to('/auth');
                    }
                }
            } else {
                session()->setFlashData('error', 'Aktifasi akun gagal... Akun sudah aktif!');
                return redirect()->to('/auth');
            }
        } else {
            session()->setFlashData('error', 'Aktifasi akun gagal... Token tidak valid!');
            return redirect()->to('/auth');
        }
    }

    public function notready()
    {
        $data = [
            'jadwal' => $this->jadwal->where('status', 1)->groupBy('tgl_ujian')->first()
        ];

        return view('notready', $data);
    }
}
