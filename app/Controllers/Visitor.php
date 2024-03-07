<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VisitorModel;

class Visitor extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new VisitorModel();
        $data = $model->orderBy('id', 'ASC')->findAll();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function show($id = null)
    {
        $model = new VisitorModel();
        $data = $model->where('id', $id)->orderBy('id', 'ASC')->first();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function create()
    {
        $model = new VisitorModel();
        $data = array(
            'nama' => $this->request->getVar('nama'),
            'url' => $this->request->getVar('url'),
            'slug' => slug($this->request->getVar('nama')),
            'parent' => $this->request->getVar('parent'),
            'urut' => $this->request->getVar('urut'),
            'tipe' => $this->request->getVar('tipe'),
            'status' => $this->request->getVar('status'),
        );
        $insert = $model->insert($data);
        if ($insert) {
            $message = [
                'status' => 200,
                'notif' => 'Success',
                'id' => base_url('view-admin-menu')
            ];
        } else {
            $message = array('status' => 404, 'notif' => 'Failed');
        }
        return $this->respond($message);
    }
}