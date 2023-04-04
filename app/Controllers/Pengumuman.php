<?php

namespace App\Controllers;

class Pengumuman extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pengumuman',
            'titlecontent' => 'Pengumuman',
            'setting' => $this->apps->first(),
        ];

        return view('pengumuman', $data);
    }

    public function viewdata()
    {
        $dtpost = $this->request->getVar();
        $draw = $dtpost['draw'];
        $start = $dtpost['start'];
        $rowPerPage = $dtpost['length'];
        $columnIndex = $dtpost['order'][0]['column'];
        $searchValue = $dtpost['search']['value'];

        $totalRows = $this->pengumuman->countAllResults();
        $totalRowsWithFilter = $this->pengumuman
            ->orlike('uid', $searchValue)
            ->orlike('judul', $searchValue)
            ->orlike('user', $searchValue)
            ->orlike('text', $searchValue)
            ->orlike('crdate', $searchValue)
            ->countAllResults();

        $no = $start;
        $array = array();

        if ($rowPerPage == -1) {
            $records = $this->pengumuman
                ->orlike('uid', $searchValue)
                ->orlike('judul', $searchValue)
                ->orlike('user', $searchValue)
                ->orlike('text', $searchValue)
                ->orlike('crdate', $searchValue)
                ->orderBy('crdate', 'DESC')
                ->findAll();
        } else {
            $records = $this->pengumuman
                ->orlike('uid', $searchValue)
                ->orlike('judul', $searchValue)
                ->orlike('user', $searchValue)
                ->orlike('text', $searchValue)
                ->orlike('crdate', $searchValue)
                ->orderBy('crdate', 'DESC')
                ->findAll($rowPerPage, $start);
        }

        foreach ($records as $key) {
            $no++;

            $data = array();
            $data[] = '<a href="#">' . $key['judul'] . '</a>';
            $data[] = $key['user'];
            $data[] = $key['crdate'];
            $data[] = '<div class="text-center">
                <button class="btn btn-xs btn-secondary btn-edit" data-id="' . $key['uid'] . '" data-href="/admin/pengumuman/edit/' . $key['uid'] . '"><i class="fa fa-pencil fa-sm"></i></button>
                <button class="btn btn-xs btn-danger btn-delete" data-href="/admin/pengumuman/delete/' . $key['uid'] . '"><i class="fa fa-trash fa-sm"></i></button>
            </div>';
            $array[] = $data;
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRows,
            'iTotalDisplayRecords' => $totalRowsWithFilter,
            'data' => $array,

        ];

        return $this->response->setJSON($response);
    }

    public function save()
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'infovalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $entities = new \CodeIgniter\Entity\Entity;
            $entities->fill($data);
            $entities->uid = date('YmdHis');
            $entities->type = '';
            $entities->text = $data['teks'];
            $entities->user = session()->fname;

            if ($this->pengumuman->save($entities)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
            }
        }
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pengumuman',
            'data' => $this->pengumuman->find($id),
            'action' => '/pengumuman/update/' . $id
        ];

        return $this->response->setJSON($data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $validate = $this->validation->run($data, 'infovalidate');
        $errors = $this->validation->getErrors();

        if ($errors) {
            return $this->response->setJSON($errors)->setStatusCode(404);
        } else {
            $entities = new \CodeIgniter\Entity\Entity;
            $entities->fill($data);
            $entities->type = '';
            $entities->text = $data['teks'];
            $entities->user = session()->fname;

            if ($this->pengumuman->update($id, $entities)) {
                return $this->response->setJSON(['success' => 'Data berhasil disimpan']);
            } else {
                return $this->response->setJSON(['error' => 'Data gagal disimpan!'])->setStatusCode(400);
            }
        }
    }

    public function delete($id)
    {
        if ($this->pengumuman->delete($id)) {
            return $this->response->setJSON(['success' => 'Data berhasil dihapus...']);
        } else {
            return $this->response->setJSON(['error' => 'Data gagal dihapus!!!'])->setStatusCode(400);
        }
    }
}
