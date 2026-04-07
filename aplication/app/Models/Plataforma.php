<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Plataforma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao'
    ];
    protected $with = ['createdBy'];

    // public function itens(): BelongsToMany
    // {
    //     return $this->belongsToMany(
    //         Item::class,
    //         'plataforma_item',
    //         'plataforma_id',
    //         'item_id'
    //     );
    // }

    public function itens(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'plataforma_item_subitem_fornecedor', 'plataforma_id', 'item_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
