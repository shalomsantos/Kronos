<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BzeroPlataformaItemSubitemFornecedor extends Model
{
    protected $table = 'bzero_plataforma_item_subitem_fornecedor';

    use HasFactory;

    protected $fillable = [
        'bzero_id',
        'plataforma_id',
        'item_id',
        'subitem_id',
        'fornecedor_id',
        'vl_unit_cot',
        'qt_unid_cot',
        'multip_cot',
        'vl_unit_apr',
        'qt_unid_apr',
        'multip_apr',
        'vl_executado'
    ];

    public function getTotalCotAttribute()
    {
        return ($this->vl_unit_cot * $this->qt_unid_cot) * $this->multip_cot;
    }
    public function getTotalAprAttribute()
    {
        return ($this->vl_unit_apr * $this->qt_unid_apr) * $this->multip_apr;
    }
}
