<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountModel extends Model
{
    use HasFactory;

    protected $table = 'count';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'number'
    ];

}
