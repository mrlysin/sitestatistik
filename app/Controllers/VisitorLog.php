<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\VisitorLogModel;
use App\Models\VisitorModel;

class VisitorLog extends ResourceController
{
    use ResponseTrait;

    public function index()
    {
        $model = new VisitorLogModel();
        $data = $model->orderBy('id', 'DESC')->limit(5)->findAll();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    function siteVisitor()
    {
        $today = new VisitorLogModel();
        $day = $today->where('date(visitdate)', date('Y-m-d'))->countAllResults();
        $message = [
            'status' => 200,
            'notif' => "Success",
            'date' => date('Y-m-d'),
            'day' => $day,
            'online' => $this->onlineVisitor(),
            'total' => $this->totalVisitor(),
        ];
        return $this->respond($message);
    }

    function onlineVisitor()
    {
        $ol = new VisitorLogModel();
        $bataswaktu = time() - 300;
        $online = $ol->select("count(*) as jumlah")->where('online > ', $bataswaktu)->first();
        if (empty($online)) {
            $online = '0';
        } else {
            $online = $online['jumlah'];
        }
        return $online;
    }

    function totalVisitor()
    {
        $tot = new VisitorModel();
        $total = $tot->select('(sum(month01) + sum(month02) + sum(month03) + sum(month04) +
        sum(month05) + sum(month06) + sum(month07) + sum(month08) + sum(month09) +
        sum(month10) + sum(month11) + sum(month12)) as total')->first();
        return $total['total'];
    }

    public function todayVisitor()
    {
        $model = new VisitorLogModel();
        $count = $model->where('date(visitdate)', $this->request->getVar('date'))->countAllResults();
        $data = $model->where('date(visitdate)', $this->request->getVar('date'))->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'visitor' => $count, 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function monthVisitor()
    {
        $model = new VisitorLogModel();
        $where = ['month(visitdate)' => $this->request->getVar('month'), 'year(visitdate)' => $this->request->getVar('year')];
        $count = $model->where($where)->countAllResults();
        $data = $model->where($where)->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'visitor' => $count, 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function yearVisitor()
    {
        $model = new VisitorLogModel();
        $count = $model->where('year(visitdate)', $this->request->getVar('year'))->countAllResults();
        $data = $model->where('year(visitdate)', $this->request->getVar('year'))->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'visitor' => $count, 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function rangedate()
    {
        $model = new VisitorLogModel();
        $where = ['date(visitdate) >=' => $this->request->getVar('firstdate'), 'date(visitdate) <=' => $this->request->getVar('lastdate')];
        $count = $model->where($where)->countAllResults();
        $data = $model->where($where)->orderBy('id', 'DESC')->findAll();
        if ($data) {
            $message = [
                'status' => 200, 'notif' => "Success",
                'firstdate' => $this->request->getVar('firstdate'),
                'lastdate' => $this->request->getVar('lastdate'),
                'visitor' => $count, 'data' => $data
            ];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function statisticVisitor()
    {
        $model = new VisitorModel();
        $data = $model->where('years', $this->request->getVar('year'))->orderBy('id', 'DESC')->first();
        if ($data) {
            $message = ['status' => 200, 'notif' => "Success", 'data' => $data];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function visitorByCountry()
    {
        $model = new VisitorLogModel();
        $data = $model->select("countrycode, countryname, count(id) as visitor")
            ->where('year(visitdate)', $this->request->getVar('year'))
            ->groupBy('countrycode')
            ->orderBy('id', 'DESC')
            ->findAll();
        if ($data) {
            $message = [
                'status' => 200,
                'notif' => "Success",
                'years' => $this->request->getVar('year'),
                'data' => $data
            ];
            return $this->respond($message);
        } else {
            $message = ['status' => 404, 'notif' => "Not found"];
            return $this->respond($message);
        }
    }

    public function addWebVisitor()
    {
        $model = new VisitorLogModel();

        $modelv = new VisitorModel();

        $check = $this->checkVisitor($this->request->getVar('ip'));

        $checkmonth = $this->checkVisitorMonth();

        $month = 'month' . date('m');

        if (empty($check)) {
            $dataisert = array(
                'ip_address' => $this->request->getVar('ip'),
                'countrycode' => getcountry('code', $this->request->getVar('ip')),
                'countryname' => getcountry('name', $this->request->getVar('ip')),
                'platform' => $this->request->getVar('platform'),
                'platformdetail' => $this->request->getVar('platformdetail'),
                'agent' => $this->request->getVar('agent'),
                'referrer' => $this->request->getVar('referrer'),
                'online' => time(),
            );
            $model->insert($dataisert);
            if (!empty($checkmonth)) {
                $dataupdate = array($month => $checkmonth[$month] + 1);
                $insert = $modelv->update($checkmonth['id'], $dataupdate);
            } else {
                $dataupdate = array('years' => date('Y'), $month => 1);
                $insert = $modelv->insert($dataupdate);
            }
        } else {
            $dataupdate = array('online' => time());
            $insert = $model->update($check['id'], $dataupdate);
        }

        if ($insert) {
            $message = ['status' => 200, 'notif' => 'Success'];
        } else {
            $message = ['status' => 404, 'notif' => 'Failed'];
        }
        return $this->respond($message);
    }

    function checkVisitor($ip)
    {
        $model = new VisitorLogModel();
        $where = array('ip_address' => $ip, 'date(visitdate)' => date('Y-m-d'));
        $data = $model->where($where)->orderBy('id', 'ASC')->first();
        return $data;
    }

    function checkVisitorMonth()
    {
        $model = new VisitorModel();
        // $month = 'month' . date('m');
        $where = array('years' => date('Y'));
        $data = $model->where($where)->orderBy('id', 'ASC')->first();
        return $data;
    }

    public function test()
    {
        // $ipl = new IP2Location_lib();
        // $ip = '103.162.68.19';
        // echo $ipl->getCountryCode($ip);
        // echo $ipl->getCountryName($ip);
        // echo $ipl->getRegionName($ip);
        // echo $ipl->getCityName($ip);
        // echo $ipl->getLatitude($ip);
        echo getcountry('code', '103.162.68.19');
        echo ' - ' . getcountry('name', '103.162.68.19');
        echo ' - ' . useragent('platform');
        echo ' - ' . useragent('agent');
        echo ' - ' . useragent('referrer');
        echo ' - ' . useragent('all');
        echo ' - ' . thisIP();
        // $model = new VisitorLogModel();
        // $data = $model->orderBy('id', 'ASC')->findAll();
        // if ($data) {
        //     $message = ['status' => 200, 'notif' => "Success", 'data' => $data];
        //     return $this->respond($message);
        // } else {
        //     $message = ['status' => 404, 'notif' => "Not found"];
        //     return $this->respond($message);
        // }
    }
}
