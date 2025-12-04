<x-guest-layout>

    <div class="max-w-3xl mx-auto mt-10 mb-8 px-4">

        {{-- Card de resultados --}}
        <div class="bg-white/95 p-8 rounded-3xl shadow-2xl border border-gray-200">
            <h1 class="text-2xl md:text-3xl font-bold mb-2 text-center text-gray-900">
                {{ $votacion->titulo }}
            </h1>
            <p class="text-sm text-gray-500 text-center mb-6">
                Resultados actualizados en tiempo real.
            </p>

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

                    <div id="opcion-{{ $opcion->id }}" class="pt-1">
                        <div class="flex justify-between mb-1">
                            <span class="font-medium text-gray-800">
                                {{ $opcion->opcion_disponible }}
                            </span>

                            <span class="text-xs md:text-sm text-gray-600"
                                  id="opcion-{{ $opcion->id }}-texto">
                                {{ $votosOpcion }} votos ({{ $porcentaje }}%)
                            </span>
                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-4 md:h-5 overflow-hidden">
                            <div class="h-4 md:h-5 rounded-full transition-all duration-500
                                        bg-gradient-to-r from-indigo-500 via-blue-500 to-cyan-400"
                                 id="opcion-{{ $opcion->id }}-barra"
                                 style="width: {{ $porcentaje }}%">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between items-center mt-8 mb-4">
                {{-- Botón volver --}}
                <p class="text-center text-gray-600 text-base">
                    Total de votos:
                    <span id="total-votos" class="font-semibold text-gray-900">{{ $totalVotos }}</span>
                </p>
                <div><a href="javascript:history.back()"
                    class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                        ← Volver
                    </a></div>
            </div>
        </div>
    </div>

    {{-- Script que escucha Echo --}}
    @push('scripts')
        @vite('resources/js/resultados-socket.js')
    @endpush

</x-guest-layout>
