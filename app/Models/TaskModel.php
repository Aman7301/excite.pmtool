<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = 'task';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'Task',
        'project_id',
        'project_name'
    ];
}
