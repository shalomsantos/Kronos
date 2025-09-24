<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'tipo_projeto_id'
    ];

    public function TipoProjeto(): BelongsTo
    {
        return $this->belongsTo(TipoProjeto::class);
    }
    public function bzero(): HasOne
    {
        return $this->hasOne(Bzero::class);
    }
}
