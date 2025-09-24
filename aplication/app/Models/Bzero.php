<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bzero extends Model
{
    use HasFactory;

    protected $fillable = [
        'projeto_id',
        'status_id',
        'ano',
        'dt_aprovacao',
        'descricao'
    ];

    protected $with = ['projeto', 'status', 'createdBy'];

    public function projeto(): BelongsTo
    {
        return $this->belongsTo(Projeto::class);
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
