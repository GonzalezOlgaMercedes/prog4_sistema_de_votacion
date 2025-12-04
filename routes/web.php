<?php

use App\Events\VotacionCerrada;
use App\Events\VotoEmitido;
use App\Http\Controllers\ProfileController;
use App\Models\Votacion;
use App\Models\Voto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
    $voto = Voto::create([
        'uuid' => $validated['uuid'],
        'votacion_id' => $votacion['id'],
        'opcion_id' => $validated['opcion_id'],
    ]);

    //Disparamos un evento Socket
    Log::info("Disparando evento VotoEmitido para el voto ID: " . $voto->id);
    event(new VotoEmitido($voto));
    Log::info("Evento VotoEmitido disparado para el voto ID: " . $voto->id);

    //Redirigir a la página de resultados
    return redirect('/resultados/'.$votacion->id)->with('status', 'Voto registrado exitosamente.');
})->name('voto.store');

Route::get('/resultados/{id}', function ($id) {
    $votacion = Votacion::with('votos.opcion')->findOrFail($id);
    return view('resultados', ['votacion' => $votacion]);
})->name('resultados');

require __DIR__.'/auth.php';

Route::put('/votacion/{id}/alternar', function ($id) {
    $votacion = Votacion::findOrFail($id);
    if($votacion->estado == 'cerrada'){
        $votacion->estado = 'abierta';
    } else {
        $votacion->estado = 'cerrada';
        event(new VotacionCerrada($votacion));
    }
    $votacion->save();
    return redirect()->back()->with('status', 'Votación '.$votacion->estado.' exitosamente.');
})->middleware(['auth'])->name('votacion.alternar');

Route::get('/votacion/nueva', function () {
    return view('form_votacion');
})->middleware(['auth'])->name('votacion.nueva');

Route::get('/votacion/{id}/editar', function ($id) {
    $votacion = Votacion::with('opciones')->findOrFail($id);
    return view('form_votacion', ['votacion' => $votacion]);
})->middleware(['auth'])->name('votacion.editar');

Route::post('/votacion', function (Request $request) {
    Log::info($request->all());
    $request->validate([
        'titulo' => 'required|string|max:255',
        'opciones' => 'required|array|min:1',
        'opciones.*.texto' => 'required|string|max:255',
        'opciones.*.id' => 'nullable|integer'
    ]);

    $votacion = Votacion::create([
        'titulo' => $request->titulo,
        'estado' => 'abierta',
    ]);

    foreach ($request->opciones as $opcionForm) {
        $votacion->opciones()->create([
            'opcion_disponible' => $opcionForm["texto"],
        ]);
    }

    return redirect()->route('votacion.editar', $votacion->id)
        ->with('success', 'Votación creada correctamente.');
})->middleware(['auth'])->name('votacion.guardar');

Route::put('/votacion/{id}', function (Request $request, $id) {
    $request->validate([
        'titulo' => 'required|string|max:255',
        'opciones' => 'required|array|min:1',
        'opciones.*.texto' => 'required|string|max:255',
        'opciones.*.id' => 'nullable|integer'
    ]);

    $votacion = Votacion::with('opciones.votos')->findOrFail($id);

    // Actualizar título
    $votacion->update(['titulo' => $request->titulo]);

    $idsRecibidos = collect($request->opciones)->pluck('id')->filter()->toArray();

    // 1) ELIMINAR opciones sin votos que no estén en el form
    foreach ($votacion->opciones as $op) {
        if (!in_array($op->id, $idsRecibidos)) {
            if ($op->votos->count() === 0) {
                $op->delete(); // solo borrar si no tiene votos
            }
        }
    }

    // 2) ACTUALIZAR o CREAR opciones
    foreach ($request->opciones as $opcionForm) {

        // OPCIÓN EXISTENTE
        if (!empty($opcionForm["id"])) {
            $op = $votacion->opciones->firstWhere('id', $opcionForm["id"]);

            if ($op) {
                // tiene votos → NO se puede editar
                if ($op->votos->count() === 0) {
                    $op->update([
                        'opcion_disponible' => $opcionForm["texto"]
                    ]);
                }
            }
        } 
        
        // OPCIÓN NUEVA
        else {
            $votacion->opciones()->create([
                'opcion_disponible' => $opcionForm["texto"]
            ]);
        }
    }

    return redirect()->route('dashboard')->with('status', 'Votación actualizada.');

})->middleware(['auth'])->name('votacion.actualizar');
