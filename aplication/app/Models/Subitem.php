<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subitem extends Model
{
    protected $table = 'subitens';

    use HasFactory;

    protected $fillable = [
        'nome'
    ];
}
