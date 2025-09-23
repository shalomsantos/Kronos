<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anexo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_arquivo',
        'descricao',
        'extensao',
        'path',
        'bz_plat_item_subitem_form_id'
    ];
}
