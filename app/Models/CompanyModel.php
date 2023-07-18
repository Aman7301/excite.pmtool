<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;

    protected $primaryKey = "id";
    protected $table = "company";

    protected $fillable = [
        'id',
        'company_name',
        'owner_name',
        'company_address',
        'company_detail'
    ];
}
