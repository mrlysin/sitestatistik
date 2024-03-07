<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'visitor';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
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
