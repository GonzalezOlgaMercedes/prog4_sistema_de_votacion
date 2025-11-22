<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $table = 'votos';

    protected $fillable = [
        'usuario_id',
        'votacion_id',
        'opcion_id',
    ];
}
