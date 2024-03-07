<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ViewerpageLogModel;
use App\Models\ViewerpageModel;

class ViewerpageLog extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new ViewerpageLogModel();
        $data = $model->orderBy('id', 'ASC')->findAll();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function kontenViewer()
    {
        $model = new ViewerpageLogModel();
        $whereCheck = [
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $Check = $model->where($whereCheck)->orderBy('id', 'DESC')->first();

        if ($Check) {
            $where = [
                'date(viewdate)' => date('Y-m-d'),
                'id_post' => $this->request->getVar('id'),
                'name_post' => $this->request->getVar('name')
            ];
            $count = $model->where($where)->countAllResults();
            $message = [
                'status' => 200,
                'notif' => "Success",
                'date' => date('Y-m-d'),
                'day' => $count,
                'month' => $this->monthViewer(),
                'year' => $this->yearViewer(),
                'total' => $this->totalViewer()
            ];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function monthViewer()
    {
        $total = new ViewerpageModel();

        $wheretotal = [
            'years' => date('Y'),
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $cektotal = $total->where($wheretotal)->first();
        $month = "month" . date('m');
        return $cektotal[$month];
    }

    public function yearViewer()
    {
        $total = new ViewerpageModel();

        $wheretotal = [
            'years' => date('Y'),
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $cektotal = $total->where($wheretotal)->first();
        return $cektotal['month01'] + $cektotal['month02'] + $cektotal['month03'] +
            $cektotal['month04'] + $cektotal['month05'] + $cektotal['month06'] +
            $cektotal['month07'] + $cektotal['month08'] + $cektotal['month09'] +
            $cektotal['month10'] + $cektotal['month11'] + $cektotal['month12'];
    }

    public function totalViewer()
    {
        $total = new ViewerpageModel();

        $wheretotal = [
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $cektotal = $total->select('sum(month01) as month01, sum(month02) as month02, sum(month03) as month03, sum(month04) as month04,
        sum(month05) as month05, sum(month06) as month06, sum(month07) as month07, sum(month08) as month08, sum(month09) as month09,
        sum(month10) as month10, sum(month11) as month11, sum(month12) as month12')->where($wheretotal)->first();
        return $cektotal['month01'] + $cektotal['month02'] + $cektotal['month03'] +
            $cektotal['month04'] + $cektotal['month05'] + $cektotal['month06'] +
            $cektotal['month07'] + $cektotal['month08'] + $cektotal['month09'] +
            $cektotal['month10'] + $cektotal['month11'] + $cektotal['month12'];
    }

    public function todayViewerDetail()
    {
        $model = new ViewerpageLogModel();
        $where = [
            'date(viewdate)' => $this->request->getVar('date'),
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $count = $model->where($where)->countAllResults();
        $data = $model->where($where)->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = [
                'status' => 200,
                'notif' => "Success",
                'date' => $this->request->getVar('date'),
                'viewer' => $count,
                'data' => $data
            ];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function monthViewerDetail()
    {
        $model = new ViewerpageLogModel();
        $where = [
            'month(viewdate)' => $this->request->getVar('month'),
            'year(viewdate)' => $this->request->getVar('year'),
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $count = $model->where($where)->countAllResults();
        $data = $model->where($where)->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = [
                'status' => 200,
                'notif' => "Success",
                'year' => $this->request->getVar('year'),
                'month' => $this->request->getVar('month'),
                'viewer' => $count,
                'data' => $data
            ];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function yearViewerDetail()
    {
        $model = new ViewerpageLogModel();
        $where = [
            'year(viewdate)' => $this->request->getVar('year'),
            'id_post' => $this->request->getVar('id'),
            'name_post' => $this->request->getVar('name')
        ];
        $count = $model->where($where)->countAllResults();
        $data = $model->where($where)->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = [
                'status' => 200,
                'notif' => "Success",
                'year' => $this->request->getVar('year'),
                'viewer' => $count,
                'data' => $data
            ];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function addPageViewer()
    {
        $ip = $this->request->getVar('ip');
        $id = $this->request->getVar('id');
        $name = $this->request->getVar('name');

        $model = new ViewerpageLogModel();

        $modelv = new ViewerpageModel();

        $check = $this->checkPageViewer($ip, $id, $name);

        $checkmonth = $this->checkPageViewerMonth($id, $name);

        $month = 'month' . date('m');

        if (empty($check)) {
            $dataisert = array(
                'ip_address' => $ip,
                'id_post' => $id,
                'name_post' => $name,
                'countrycode' => getcountry('code', $ip),
                'countryname' => getcountry('name', $ip),
                'platform' => $this->request->getVar('platform'),
                'platformdetail' => $this->request->getVar('platformdetail'),
                'agent' => $this->request->getVar('agent'),
                'referrer' => $this->request->getVar('referrer'),
            );
            $model->insert($dataisert);
            if (!empty($checkmonth)) {
                $dataupdate = array($month => $checkmonth[$month] + 1);
                $insert = $modelv->update($checkmonth['id'], $dataupdate);
            } else {
                $dataupdate = array('years' => date('Y'), $month => 1, 'name_post' => $name, 'id_post' => $id);
                $insert = $modelv->insert($dataupdate);
            }
        }

        if ($insert) {
            $message = ['status' => 200, 'notif' => 'Success'];
        } else {
            $message = ['status' => 404, 'notif' => 'Failed'];
        }
        return $this->respond($message);
    }

    function checkPageViewer($ip, $id, $name)
    {
        $model = new ViewerpageLogModel();
        $where = array('ip_address' => $ip, 'date(viewdate)' => date('Y-m-d'), 'name_post' => $name, 'id_post' => $id);
        $data = $model->where($where)->orderBy('id', 'ASC')->first();
        return $data;
    }

    function checkPageViewerMonth($id, $name)
    {
        $model = new ViewerpageModel();
        $where = array('years' => date('Y'), 'name_post' => $name, 'id_post' => $id);
        $data = $model->where($where)->orderBy('id', 'ASC')->first();
        return $data;
    }
}
