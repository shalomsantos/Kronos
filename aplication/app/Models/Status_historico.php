<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_historico extends Model
{
    use HasFactory;

    protected $fillable = [
        'bzero_id',
        'status_antigo_id',
        'status_novo_id'
    ];
}
