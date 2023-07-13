<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveModel extends Model
{
    use HasFactory;

    protected $table = 'emp_leave';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'start_date',
        'end_date',
        'leave_type',
        'reason'
    ];
}
