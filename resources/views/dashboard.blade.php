<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Panel de Votaciones
                </h2>
                <p class="text-sm text-gray-600 dark:text-white mt-1">
                    Gestioná fácilmente las votaciones del sistema.
                </p>
            </div>

            <a href="{{ route('votacion.nueva') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl 
                      bg-indigo-600 hover:bg-indigo-500
                      text-white text-sm font-semibold shadow-md transition">
                + Nueva Votación
            </a>
        </div>
    </x-slot>

    <div class="py-10 min-h-screen bg-gradient-to-br from-blue-100 via-indigo-100 to-cyan-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

            
            @php
            $total = $votaciones->count();
            $abiertas = $votaciones->where('estado', 'abierta')->count();
                $cerradas = $votaciones->where('estado', 'cerrada')->count();
            @endphp

            {{-- Tarjetas estadísticas --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-200">
                    <p class="text-xs font-semibold text-gray-500 uppercase">Votaciones Totales</p>
                    <p class="mt-2 text-3xl font-bold text-gray-800">{{ $total }}</p>
                </div>
                
                <div class="bg-white shadow-md rounded-2xl p-6 border border-green-300">
                    <p class="text-xs font-semibold text-green-600 uppercase">Votaciones Abiertas</p>
                    <p class="mt-2 text-3xl font-bold text-green-600">{{ $abiertas }}</p>
                </div>
                
                <div class="bg-white shadow-md rounded-2xl p-6 border border-gray-300">
                    <p class="text-xs font-semibold text-gray-600 uppercase">Votaciones Cerradas</p>
                    <p class="mt-2 text-3xl font-bold text-gray-600">{{ $cerradas }}</p>
                </div>
                
            </div>
            {{-- Mensaje flash --}}
            @if (session('status'))
                <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded-xl">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Tabla --}}
            <div class="bg-white shadow-xl rounded-3xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800">Lista de Votaciones</h3>
                    <p class="text-sm text-gray-500">
                        Estados, accesos rápidos y acciones principales.
                    </p>
                </div>

                @if ($votaciones->isEmpty())
                    <div class="px-6 py-8 text-center text-gray-600">
                        No hay votaciones creadas aún.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700">
                            <thead class="bg-indigo-100 text-indigo-700 text-xs uppercase tracking-wide">
                                <tr>
                                    <th class="py-3 px-6 text-left">ID</th>
                                    <th class="py-3 px-6 text-left">Título</th>
                                    <th class="py-3 px-6 text-left">Estado</th>
                                    <th class="py-3 px-6 text-right">Acciones</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($votaciones as $votacion)
                                    <tr class="hover:bg-gray-50">
                                        
                                        <td class="py-3 px-6 text-gray-500">#{{ $votacion->id }}</td>

                                        <td class="py-3 px-6 font-medium text-gray-800">
                                            {{ $votacion->titulo }}
                                        </td>

                                        <td class="py-3 px-6">
                                            @php
                                                $estado = $votacion->estado;
                                                $class = $estado == 'abierta'
                                                    ? 'bg-green-100 text-green-700 border-green-300'
                                                    : 'bg-gray-200 text-gray-700 border-gray-300';
                                            @endphp

                                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $class }}">
                                                {{ ucfirst($estado) }}
                                            </span>
                                        </td>

                                        <td class="py-3 px-6 text-right flex items-center justify-end gap-2">

                                            {{-- Abrir / cerrar --}}
                                            <form action="{{ route('votacion.alternar', $votacion->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="px-3 py-1.5 rounded-xl text-xs font-semibold 
                                                               border border-indigo-400 text-indigo-600
                                                               hover:bg-indigo-50 transition">
                                                    {{ $estado == 'abierta' ? 'Cerrar' : 'Abrir' }}
                                                </button>
                                            </form>

                                            {{-- Editar --}}
                                            @if($estado == 'abierta')
                                                <span class="px-3 py-1.5 rounded-xl text-xs font-semibold 
                                                             bg-gray-200 text-gray-400 cursor-not-allowed">
                                                    Editar
                                                </span>
                                            @else
                                                <a href="{{ route('votacion.editar', $votacion->id) }}"
                                                   class="px-3 py-1.5 rounded-xl text-xs font-semibold 
                                                          border border-amber-400 text-amber-600
                                                          hover:bg-amber-50 transition">
                                                    Editar
                                                </a>
                                            @endif

                                            {{-- Resultados --}}
                                            <a href="{{ route('resultados', $votacion->id) }}"
                                               class="px-3 py-1.5 rounded-xl text-xs font-semibold 
                                                      border border-green-400 text-green-600
                                                      hover:bg-green-50 transition">
                                                Resultados
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
