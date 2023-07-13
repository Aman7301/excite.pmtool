<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfessionalModel extends Model
{
    use HasFactory;

    protected $table = 'emp_professional';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'company',
        'designation',
        'start_date',
        'end_date'
    ];
}
