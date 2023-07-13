<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayModel extends Model
{
    use HasFactory;

    protected $table = 'holiday';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'location',
        'year',
        'holiday_type',
        'date'
    ];
}
