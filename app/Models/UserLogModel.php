<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLogModel extends Model
{
    protected $table = 'user_log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'id_user',
        'username',
        'url',
        'dataid',
        'countrycode',
        'countryname',
        'ip_address',
        'platform',
        'agent',
        'platformdetail',
        'referrer',
        'dateaction'
    ];
}
