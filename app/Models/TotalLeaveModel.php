<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalLeaveModel extends Model
{
    use HasFactory;

    protected $table = 'emp_total_leave';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'total'
    ];
}
