<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'opcions';
    protected $fillable = [
        'opcion_disponible',
        'votacion_id',
    ];

    public function votacion()
    {
        return $this->belongsTo(Votacion::class);
    }
    public function votos()
    {
        return $this->hasMany(Voto::class);
    }
}
