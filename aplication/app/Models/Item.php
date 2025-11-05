<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    protected $table = 'itens';

    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    protected $with = ['subitens', 'createdBy'];

    public function subitens(): BelongsToMany
    {
        return $this->belongsToMany(Subitem::class, 'item_subitem', 'item_id', 'subitem_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
