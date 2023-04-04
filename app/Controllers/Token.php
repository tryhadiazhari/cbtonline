<?php

namespace App\Controllers;

class Token extends BaseController
{
    public function __construct()
    {
        function create_random($length)
        {
            $data = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $string = '';
            for ($i = 0; $i < $length; $i++) {
                $pos = rand(0, strlen($data) - 1);
                $string .= $data[$pos];
            }
            return $string;
        }
    }

    public function index()
    {
        $cek = $this->db->query("SELECT * FROM token")->getResult();
        $query = $this->db->query("SELECT * FROM token")->getRowArray();

        $data = [
            'title' => 'Token',
            'titlecontent' => 'Token',
            'breadcrumb' => 'Token',
            'setting' => $this->apps->first(),
            'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
            'token' => (count($cek) == 0) ? 'Belum tersedia...' : $query['token'],
            'akses' => $this->db->query("SELECT hazedu_menu.type, hazedu_menu.parent, hazedu_menu.kode_menu, 
							hazedu_menu.menu_name, hazedu_menu.url, hazedu_menu.icon, hazedu_menu.sort, 
							hazedu_menu_access.lvl, hazedu_menu_access.`add`, hazedu_menu_access.edt, 
							hazedu_menu_access.del, hazedu_menu_access.`import`
								FROM hazedu_menu 
									INNER JOIN hazedu_menu_access ON hazedu_menu.kode_menu = hazedu_menu_access.kode_menu 
                                    INNER JOIN hazedu_users ON hazedu_menu_access.lvl = hazedu_users.lv 
										WHERE hazedu_menu_access.lvl = '" . session()->lv . "' AND hazedu_menu.menu_name = 'Token'
                                            ORDER BY hazedu_menu.sort ASC")->getRowArray()
        ];

        return view('token', $data);
    }

    public function check($action = null)
    {
        $cek = $this->db->query("SELECT * FROM token")->getResult();
        $query = $this->db->query("SELECT * FROM token")->getRowArray();
        $token = create_random(6);

        $now = date('Y-m-d H:i:s');

        if ($action == 'generate') {
            if (count($cek) > 0) {
                $time = $query['time'];

                $this->db->table('token')->where('id_token', 1)->update([
                    'token' => $token,
                    'time' => $now,
                    'expired_date' => date('Y-m-d H:i:s', strtotime('+ 15 minutes', strtotime($now)))
                ]);
            } else {
                $this->db->table('token')->insert(
                    array(
                        'token' => $token,
                        'time' => $now,
                        'expired_date' => date('Y-m-d H:i:s', strtotime('+ 15 minutes', strtotime($now)))
                    )
                );
            }

            return $this->response->setJSON(['token' => $token]);
        } else {
            if (count($cek) > 0) {
                $time = $query['time'];

                $this->db->table('token')->where('id_token', 1)->update([
                    'token' => $token,
                    'time' => $now,
                    'expired_date' => date('Y-m-d H:i:s', strtotime('+ 15 minutes', strtotime($now)))
                ]);
            }

            return $this->response->setJSON(['token' => $token]);
        }
    }
}
