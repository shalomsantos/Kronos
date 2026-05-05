<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class PlataformaTemplate extends Model
{
    protected $table = 'plataforma_template';

    use HasFactory;

    protected $fillable = [
        'plataforma_id',
        'item_id',
        'subitem_id',
        'fornecedor_id',
        'vl_unit_cot',
        'qt_unidade_cot',
        'qt_multip_uni_cot'
    ];

    protected $with = ['plataforma', 'item', 'subitem', 'fornecedor'];

    public function plataforma(): HasOne
    {
        return $this->hasOne(Plataforma::class, 'id', 'plataforma_id');
    }

    public function item(): HasOne
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function subitem(): HasOne
    {
        return $this->hasOne(Subitem::class, 'id', 'subitem_id');
    }

    public function fornecedor(): HasOne
    {
        return $this->hasOne(Fornecedor::class, 'id', 'fornecedor_id');
    }
}
