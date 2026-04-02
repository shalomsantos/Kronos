<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class ItemSubitem extends Model
{
    protected $table = 'item_subitem';

    use HasFactory;

    protected $fillable = [
        'item_id',
        'subitem_id'
    ];

    public function item(): HasMany
    {
        return $this->hasMany(Item::class);
    }
    public function subitem(): HasOne
    {
        return $this->hasOne(Subitem::class, 'id', 'subitem_id');
    }
}
