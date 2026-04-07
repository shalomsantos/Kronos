<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Subitem extends Model
{
    protected $table = 'subitens';

    use HasFactory;

    protected $fillable = [
        'nome'
    ];

    protected $with = ['createdBy'];

    public function fornecedores(): BelongsToMany
    {
        return $this->belongsToMany(
            Fornecedor::class,
            'subitem_fornecedor',
            'subitem_id',
            'fornecedor_id'
        );
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
