<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    use HasFactory;

    protected $table = 'location';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'location'
    ];
}
