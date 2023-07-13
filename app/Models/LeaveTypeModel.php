<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveTypeModel extends Model
{
    use HasFactory;

    protected $table = 'emp_leave_type';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'leave_status',
        'leave_type'
    ];
}
