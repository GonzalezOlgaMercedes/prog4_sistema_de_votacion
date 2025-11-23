<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Votacion extends Model
{
    protected $table = 'votacions'; // Nombre de la tabla en la base de datos
    //fillable fields
    protected $fillable = [
        'titulo', //string
        'estado', //string 'abierta', 'cerrada'
    ];

    public function opciones()
    {
        return $this->hasMany(Opcion::class);
    }
    public function votos()
    {
        return $this->hasMany(Voto::class);
    }
}
