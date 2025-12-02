<?php

use App\Http\Controllers\ProfileController;
use App\Models\Votacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $votaciones = Votacion::where('estado','abierta')->limit(10)->get();
    return view('welcome' ,['votaciones' => $votaciones]);
});

Route::get('/dashboard', function () {
    //Dashboard debe recibir $votaciones
    $votaciones = Votacion::limit(10)->get();
    return view('dashboard', ['votaciones' => $votaciones]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/votar/{id}', function ($id) {
    $votacion = Votacion::findOrFail($id);
    if($votacion->estado != 'abierta'){
        return redirect('/')->withErrors(['votacion' => 'La votación está cerrada. No se pueden registrar más votos.']);
    }
    $uuid = request()->query('uuid',false);
    if($uuid){
        //Verificamos si ya votó, la opcion_id nos permitirá buscar la votacion correcta
        $votoExistente = \App\Models\Voto::where('uuid', $uuid)
            ->where('votacion_id', $votacion->id)
            ->first();
        if ($votoExistente) {
            return redirect('/resultados/'.$votacion->id)->withErrors(['uuid' => 'Ya ha votado en esta votación.']);
        }
    }

    return view('votar', ['votacion' => $votacion]);
})->name('votar');

Route::post('/votar/{id}', function(Request $request, $id){
    $votacion = Votacion::findOrFail($id);

    if($votacion->estado != 'abierta'){
        return redirect()->back()->withErrors(['votacion' => 'La votación está cerrada. No se pueden registrar más votos.']);
    }

    //Validar que la opción exista en la votación
    $validated = $request->validate([
        'opcion_id' => 'required|exists:opcions,id',
        'uuid' => 'required|uuid'
    ]);

    //Verificamos si ya votó, la opcion_id nos permitirá buscar la votacion correcta
    $votoExistente = \App\Models\Voto::where('uuid', $validated['uuid'])
        ->where('votacion_id', $votacion->id)
        ->first();
    if ($votoExistente) {
        return redirect()->back()->withErrors(['uuid' => 'Ya ha votado en esta votación.']);
    }

    //Verificar que la opción pertenezca a la votación
    $opcion = $votacion->opciones()->where('id', $validated["opcion_id"])->first();
    if (!$opcion) {
        return redirect()->back()->withErrors(['opcion_id' => 'La opción seleccionada no pertenece a esta votación.']);
    }

    //Crear el voto
    \App\Models\Voto::create([
        'uuid' => $validated['uuid'],
        'votacion_id' => $votacion['id'],
        'opcion_id' => $validated['opcion_id'],
    ]);

    return redirect('/')->with('status', 'Voto registrado exitosamente.');
})->name('voto.store');

Route::get('/resultados/{id}', function ($id) {
    $votacion = Votacion::with('votos.opcion')->findOrFail($id);
    return view('resultados', ['votacion' => $votacion]);
})->name('resultados');

require __DIR__.'/auth.php';
