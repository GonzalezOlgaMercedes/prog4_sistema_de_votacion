<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($votacion) ? 'Editar votación' : 'Crear nueva votación' }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 shadow rounded mt-6">
        
        <form method="POST"
              action="{{ isset($votacion) ? route('votacion.actualizar', $votacion->id) : route('votacion.guardar') }}">

            @csrf
            @if(isset($votacion))
                @method('PUT')
            @endif

            {{-- Título --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Título de la votación</label>
                <input name="titulo"
                       type="text"
                       class="w-full border px-3 py-2 rounded text-black"
                       value="{{ old('titulo', $votacion->titulo ?? '') }}"
                       required>
            </div>

            {{-- Opciones --}}
            <div class="mb-4">
                <label class="block font-semibold mb-1">Opciones</label>

                @php
                    $opciones = isset($votacion)
                        ? $votacion->opciones()->withCount('votos')->get()
                        : collect();
                @endphp

                <div id="opciones-lista" class="space-y-2">

                    @foreach($opciones as $i => $opcion)
                        <div class="flex gap-2 items-center">

                            {{-- ID --}}
                            <input type="hidden"
                                   name="opciones[{{ $i }}][id]"
                                   value="{{ $opcion->id }}">

                            {{-- Texto --}}
                            <input type="text"
                                   name="opciones[{{ $i }}][texto]"
                                   value="{{ $opcion->opcion_disponible }}"
                                   class="w-full border px-3 py-2 rounded text-black
                                        {{ $opcion->votos_count > 0 ? 'bg-gray-200 text-gray-500' : '' }}"
                                   {{ $opcion->votos_count > 0 ? 'readonly' : '' }}>

                            {{-- Botón borrar si no tiene votos --}}
                            @if($opcion->votos_count === 0)
                                <button type="button"
                                        class="px-3 py-1 bg-red-500 text-white rounded borrar-opcion">
                                    X
                                </button>
                            @else
                                <span class="text-xs text-gray-400 ml-1">
                                    {{ $opcion->votos_count }} voto(s) — bloqueada
                                </span>
                            @endif
                        </div>
                    @endforeach

                </div>

                <button type="button"
                        id="agregar-opcion"
                        class="mt-2 px-3 py-1 bg-blue-500 text-white rounded">
                    Agregar opción
                </button>
            </div>

            {{-- Botón enviar --}}
            <div class="mt-6 flex justify-end">
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    {{ isset($votacion) ? 'Actualizar' : 'Crear' }}
                </button>
            </div>
        </form>
    </div>
    {{--Errores--}}
    @if ($errors->any())
        <div class="max-w-3xl mx-auto p-4 mt-6 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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
                       class="w-full border px-3 py-2 rounded text-black"
                       required>

                <button type="button"
                        class="px-3 py-1 bg-red-500 text-white rounded borrar-opcion">
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
