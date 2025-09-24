<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    use HasFactory;

    protected $fillable = [
        'nome',
        'pai_id',
        'prox_id'
    ];

    public function bzero(): HasOne
    {
        return $this->hasOne(Bzero::class);
    }
}
