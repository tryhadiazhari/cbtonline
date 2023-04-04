<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$data = [
			'title' => 'Beranda',
			'titlecontent' => 'Dashboard',
			'breadcrumb' => 'Beranda',
			'setting' => $this->apps->first(),
			// 'databanksoal' => $this->banksoal->findAll(),
			'datasiswa' => $this->pd->findAll(),
			'datarombel' => $this->rombel->findAll(),
			// 'datasoal' => $this->soal->findAll(),
			'datamapel' => $this->mapel->findAll(),
			'datalembaga' => $this->sp->where('npsn', session()->npsn)->first(),
		];

		// dd($data['datamenu']);
		return view('index', $data);
	}
}
