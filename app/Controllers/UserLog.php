<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserLogModel;

class UserLog extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new UserLogModel();
        $data = $model->orderBy('id', 'ASC')->findAll();
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
        $ip = $this->request->getVar('ip');
        $id = $this->request->getVar('iduser');
        $name = $this->request->getVar('username');
        $model = new UserLogModel();
        $dataisert = array(
            'ip_address' => $ip,
            'id_user' => $id,
            'username' => $name,
            'dataid' => $this->request->getVar('dataid'),
            'countrycode' => getcountry('code', $ip),
            'countryname' => getcountry('name', $ip),
            'platform' => $this->request->getVar('platform'),
            'platformdetail' => $this->request->getVar('platformdetail'),
            'agent' => $this->request->getVar('agent'),
            'referrer' => $this->request->getVar('referrer'),
            'url' => $this->request->getVar('url'),
        );
        $insert = $model->insert($dataisert);
        if ($insert) {
            $message = ['status' => 200, 'notif' => "Success"];
        } else {
            $message = ['status' => 404, 'notif' => "Failed"];
        }
        return $this->respond($message);
    }
}