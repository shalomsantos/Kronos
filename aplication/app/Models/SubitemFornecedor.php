<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubitemFornecedor extends Model
{
    protected $table = 'subitem_fornecedor';

    use HasFactory;

    protected $fillable = [
        'subitem_id',
        'fornecedor_id'
    ];
}
