<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'opcions';
    protected $fillable = [
        'opcion_disponible'
    ];
}
