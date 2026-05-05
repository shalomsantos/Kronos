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
        'bzero_plataforma_item_subitem_fornecedor_id'
    ];
}
