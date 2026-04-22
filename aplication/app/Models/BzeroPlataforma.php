<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BzeroPlataforma extends Model
{
    protected $table = 'bzero_plataforma';

    use HasFactory;

    protected $fillable = [
        'bzero_id',
        'plataforma_id'
    ];
}
