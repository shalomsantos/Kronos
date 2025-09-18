<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_projeto extends Model
{
    protected $table = 'tipo_projetos';

    use HasFactory;

    protected $fillable = [
        'nome'
    ];
}
