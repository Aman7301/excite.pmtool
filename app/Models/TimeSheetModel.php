<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSheetModel extends Model
{
    use HasFactory;

    protected $table = 'timesheet';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'date',
        'project_name',
        'project_description',
        'time',
        'total'
    ];
}
