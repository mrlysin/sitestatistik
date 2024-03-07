<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VisitorModel;

class Viewerpage extends ResourceController
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
}