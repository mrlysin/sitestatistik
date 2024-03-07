<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewerpageModel extends Model
{
    protected $table = 'view_post';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'id_post',
        'name_post',
        'years',
        'month01',
        'month02',
        'month03',
        'month04',
        'month05',
        'month06',
        'month07',
        'month08',
        'month09',
        'month10',
        'month11',
        'month12',
    ];
}
