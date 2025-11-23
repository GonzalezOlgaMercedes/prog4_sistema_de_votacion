<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    protected $table = 'votos';

    protected $fillable = [
        'uuid',
        'votacion_id',
        'opcion_id',
    ];

    public function votacion()
    {
        return $this->belongsTo(Votacion::class);
    }
    public function opcion()
    {
        return $this->belongsTo(Opcion::class);
    }
}
