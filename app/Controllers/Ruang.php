<?php

namespace App\Controllers;

class Ruang extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Sarpras Ruang is Coming Soon...',
            'text' => 'Nantikan fitur ini di versi terbaru ya sobat....'
        ];

        return view('errors/html/comingsoon', $data);
    }
}
