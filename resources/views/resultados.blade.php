<x-guest-layout>
<div class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded shadow">

    <h1 class="text-2xl font-bold mb-6 text-center">{{ $votacion->titulo }}</h1>
    <h2 class="text-lg font-semibold mb-4 text-gray-700">Resultados de la votación:</h2>

    @php
        $totalVotos = $votacion->votos->count();
        $opciones = $votacion->opciones;
    @endphp

    <div class="space-y-6" id="lista-opciones">
        @foreach($opciones as $opcion)
            @php
                $votosOpcion = $opcion->votos->count();
                $porcentaje = $totalVotos > 0 ? round(($votosOpcion / $totalVotos) * 100, 2) : 0;
            @endphp

            <div id="opcion-{{ $opcion->id }}">
                <div class="flex justify-between mb-1">
                    <span class="font-medium text-gray-800">
                        {{ $opcion->opcion_disponible }}
                    </span>

                    <span class="text-gray-600"
                          id="opcion-{{ $opcion->id }}-texto">
                        {{ $votosOpcion }} votos ({{ $porcentaje }}%)
                    </span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-5">
                    <div class="bg-blue-500 h-5 rounded-full transition-all duration-500"
                         id="opcion-{{ $opcion->id }}-barra"
                         style="width: {{ $porcentaje }}%">
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 text-center text-gray-600 text-lg">
        Total de votos:
        <span id="total-votos" class="font-semibold">{{ $totalVotos }}</span>
    </div>
</div>

<a href="javascript:history.back()" class="inline-block mb-4 text-blue-500 hover:text-blue-700">
    ← Volver
</a>

{{-- Script que escucha Echo --}}
@push('scripts')
    @vite('resources/js/resultados-socket.js')
@endpush
</x-guest-layout>
