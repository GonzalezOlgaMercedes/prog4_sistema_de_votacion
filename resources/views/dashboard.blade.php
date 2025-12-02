<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">

            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-row justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold">Lista de Votaciones</h1>
                        <button class="px-3 py-2 bg-blue-500 hover:bg-blue-400 text-white font-bold rounded-lg">+ Nueva</button>
                    </div>
                <table class="min-w-full bg-white dark:bg-gray-700">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b text-left">ID</th>
                            <th class="py-2 px-4 border-b text-left">Título</th>
                            <th class="py-2 px-4 border-b text-left">Estado</th>
                            <th class="py-2 px-4 border-b text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($votaciones as $votacion)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $votacion->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $votacion->titulo }}</td>
                                <td class="py-2 px-4 border-b">{{ $votacion->estado }}</td>
                                <td class="py-2 px-4 border-b flex flex-col">
                                    <form action="{{ route('votacion.alternar', $votacion->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-blue-500 hover:underline">
                                            {{ $votacion->estado === 'abierta' ? 'Cerrar Votación' : 'Abrir Votación' }}
                                        </button>
                                    </form>
                                    <!-- Editar -->
                                    <div> <a 
                                        @if($votacion->estado === 'abierta') 
                                            class="text-gray-400 pointer-events-none cursor-not-allowed mb-2"
                                        @else
                                            href="#"
                                            class="text-blue-500 hover:underline mb-2"
                                        @endif
                                        >
                                            Editar
                                        </a>
                                    </div>
                                    <!-- quitar o agregar opciones -->
                                     <div> <a 
                                        @if($votacion->estado === 'abierta') 
                                            class="text-gray-400 pointer-events-none cursor-not-allowed mb-2"
                                        @else
                                            href="#"
                                            class="text-blue-500 hover:underline mb-2"
                                        @endif
                                        >
                                            Agregar/Quitar Opciones
                                        </a>
                                    </div>
                                     <!-- Cerrar o abrir -->
                                      <!--
                                     votacion.alternar 
                                      -->
                                    
                                    <!-- Ver Resultados -->
                                     <div> <a href="{{ route('resultados', $votacion->id) }}" class="text-blue-500 hover:underline">Ver Resultados</a> </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
