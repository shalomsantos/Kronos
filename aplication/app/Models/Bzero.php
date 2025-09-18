<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bzero extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'status_id',
        'ano',
        'dt_aprovacao',
        'descricao'
    ];
}
