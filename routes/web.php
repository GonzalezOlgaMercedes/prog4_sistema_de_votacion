<?php

use App\Http\Controllers\ProfileController;
use App\Models\Votacion;
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

require __DIR__.'/auth.php';
