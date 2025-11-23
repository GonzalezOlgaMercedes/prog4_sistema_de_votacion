<?php

namespace Database\Seeders;

use App\Models\Opcion;
use App\Models\User;
use App\Models\Votacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'is_admin' => true,
        ]);
        
        $votacion =  Votacion::create([
            'titulo' => 'Menta granizada ¿Si o no?',
            'estado' => 'cerrada',
        ]);
        
        Opcion::create([
            'opcion_disponible' => 'Si',
            'votacion_id' => $votacion->id,
        ]);
        Opcion::create([
            'opcion_disponible' => 'No',
            'votacion_id' => $votacion->id,
        ]);
        Opcion::create([
            'opcion_disponible' => '¡A la hoguera!',
            'votacion_id' => $votacion->id,
        ]);
    }
}
