<x-guest-layout>
    <!-- Pagina para ver los resultados
     
    Route::get('/resultados/{id}', function ($id) {
    $votacion = Votacion::with('votos.opcion')->findOrFail($id);
    return view('resultados', ['votacion' => $votacion]);
})->name('resultados');
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


-->
<!-- Boton para volver atras -->
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">{{ $votacion->titulo }}</h1>
    <h2 class="text-lg font-semibold mb-4 text-gray-700">Resultados de la votación:</h2>
    @php
        $totalVotos = $votacion->votos->count();
        $opciones = $votacion->opciones;
    @endphp
    <div class="space-y-6">
        @foreach($opciones as $opcion)
            @php
                $votosOpcion = $opcion->votos->count();
                $porcentaje = $totalVotos > 0 ? round(($votosOpcion / $totalVotos) * 100, 2) : 0;
            @endphp
            <div>
                <div class="flex justify-between mb-1">
                    <span class="font-medium text-gray-800">{{ $opcion->opcion_disponible }}</span>
                    <span class="text-gray-600">{{ $votosOpcion }} votos ({{ $porcentaje }}%)</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-5">
                    <div class="bg-blue-500 h-5 rounded-full transition-all duration-500"
                         style="width: {{ $porcentaje }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-8 text-center text-gray-600">
        Total de votos: <span class="font-semibold">{{ $totalVotos }}</span>
    </div>
</div>
<a href="javascript:history.back()" class="inline-block mb-4 text-blue-500 hover:text-blue-700">← Volver</a>

</x-guest-layout>