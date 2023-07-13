<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyModel extends Model
{
    use HasFactory;

    protected $table = 'emp_academy';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'degree_name',
        'college',
        'stream',
        'graduation_year',
        'CGPA'
    ];
}
