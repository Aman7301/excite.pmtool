<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExciteModel extends Model
{
    use HasFactory;

    protected $table = 'excite_system';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'company_name',
        'company_logo'
    ];
}
