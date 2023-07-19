<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePriceModel extends Model
{
    use HasFactory;

    protected $table = 'invoice_price';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'description',
        'quantity',
        'price',
        'total',
        'sub_total',
        'form_no'
    ];
}
