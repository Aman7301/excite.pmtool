<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModel extends Model
{
    use HasFactory;

    protected $table = 'emp_project_allocate';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'project_name',
        'role',
        'project_code',
        'start_date',
        'end_date'
    ];
}
