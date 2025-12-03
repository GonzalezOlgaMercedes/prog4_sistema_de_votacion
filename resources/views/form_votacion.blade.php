<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ isset($votacion) ? 'Editar votación' : 'Crear nueva votación' }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Definí el título y las opciones que estarán disponibles para los votantes.
                </p>
            </div>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 rounded-xl 
                      border border-gray-300 text-gray-700 text-sm font-semibold
                      bg-white hover:bg-gray-50 shadow-sm transition">
                ← Volver al panel
            </a>
        </div>
    </x-slot>

    @php
        $opciones = isset($votacion)
            ? $votacion->opciones()->withCount('votos')->get()
            : collect();
    @endphp

    <div class="py-10 min-h-screen bg-gradient-to-br from-blue-100 via-indigo-100 to-cyan-100">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Errores --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-2xl">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-xl rounded-3xl border border-gray-200 p-6 sm:p-8">
                <form method="POST"
                      action="{{ isset($votacion) ? route('votacion.actualizar', $votacion->id) : route('votacion.guardar') }}">

                    @csrf
                    @if(isset($votacion))
                        @method('PUT')
                    @endif

                    {{-- Título --}}
                    <div class="mb-5">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Título de la votación
                        </label>
                        <input
                            name="titulo"
                            type="text"
                            class="w-full border border-gray-300 px-3 py-2.5 rounded-xl text-gray-900 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                            value="{{ old('titulo', $votacion->titulo ?? '') }}"
                            required
                        >
                        <p class="mt-1 text-xs text-gray-500">
                            Ejemplo: “Elección de la mejor propuesta del proyecto”.
                        </p>
                    </div>

                    {{-- Opciones --}}
                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">
                            Opciones de respuesta
                        </label>
                        <p class="text-xs text-gray-500 mb-2">
                            Podés agregar, editar o eliminar opciones. Las que ya tienen votos se bloquean.
                        </p>

                        <div id="opciones-lista" class="space-y-2">
                            @foreach($opciones as $i => $opcion)
                                <div class="flex gap-2 items-center">
                                    {{-- ID --}}
                                    <input type="hidden"
                                           name="opciones[{{ $i }}][id]"
                                           value="{{ $opcion->id }}">

                                    {{-- Texto --}}
                                    <input
                                        type="text"
                                        name="opciones[{{ $i }}][texto]"
                                        value="{{ $opcion->opcion_disponible }}"
                                        class="w-full border border-gray-300 px-3 py-2.5 rounded-xl text-sm text-gray-900
                                               focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400
                                               {{ $opcion->votos_count > 0 ? 'bg-gray-100 text-gray-500 focus:ring-0 focus:border-gray-300' : '' }}"
                                        {{ $opcion->votos_count > 0 ? 'readonly' : '' }}
                                    >

                                    {{-- Botón borrar si no tiene votos --}}
                                    @if($opcion->votos_count === 0)
                                        <button type="button"
                                                class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-xs font-semibold borrar-opcion">
                                            X
                                        </button>
                                    @else
                                        <span class="text-[11px] text-gray-500 ml-1">
                                            {{ $opcion->votos_count }} voto(s) — bloqueada
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <button type="button"
                                id="agregar-opcion"
                                class="mt-3 inline-flex items-center px-4 py-2 rounded-xl text-xs font-semibold
                                       border border-indigo-400 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                            + Agregar opción
                        </button>
                    </div>

                    {{-- Botones --}}
                    <div class="mt-6 flex flex-wrap justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 text-gray-700
                                  bg-white hover:bg-gray-50 transition">
                            Cancelar
                        </a>

                        <button type="submit"
                                class="px-5 py-2 rounded-xl text-sm font-semibold
                                       bg-emerald-600 hover:bg-emerald-700 text-white shadow-md transition">
                            {{ isset($votacion) ? 'Actualizar votación' : 'Crear votación' }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        let contador = {{ count($opciones) }};

        // Agregar nueva opción
        document.getElementById('agregar-opcion').addEventListener('click', function () {
            const contenedor = document.getElementById('opciones-lista');

            const div = document.createElement('div');
            div.className = "flex gap-2 items-center";

            div.innerHTML = `
                <input type="hidden" name="opciones[${contador}][id]" value="">
                <input type="text"
                       name="opciones[${contador}][texto]"
                       class="w-full border border-gray-300 px-3 py-2.5 rounded-xl text-sm text-gray-900
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                       required>

                <button type="button"
                        class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-xl text-xs font-semibold borrar-opcion">
                    X
                </button>
            `;

            contenedor.appendChild(div);
            contador++;
        });

        // Eliminar opción sin votos
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('borrar-opcion')) {
                e.target.parentElement.remove();
            }
        });
    </script>
</x-app-layout>
                