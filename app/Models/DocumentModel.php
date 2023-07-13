<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;

    protected $table = 'emp_documents';
    protected $primarykey = 'id';

    protected $fillable = [
        'id',
        'emp_id',
        'document_type',
        'document_id',
        'reason',
        'file'
    ];
}
