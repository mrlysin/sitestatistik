<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorLogModel extends Model
{
    protected $table = 'visitor_log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'ip_address',
        'platform',
        'agent',
        'platformdetail',
        'referrer',
        'online',
        'visitdate',
        'countrycode',
        'countryname'
    ];
}
