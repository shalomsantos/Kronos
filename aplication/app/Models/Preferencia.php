<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'listagem_menu'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
