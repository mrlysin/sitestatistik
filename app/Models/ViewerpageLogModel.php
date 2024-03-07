<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewerpageLogModel extends Model
{
    protected $table = 'view_log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'id_post',
        'name_post',
        'countrycode',
        'countryname',
        'ip_address',
        'platform',
        'agent',
        'platformdetail',
        'referrer',
        'online',
        'viewdate',
        
    ];
}
