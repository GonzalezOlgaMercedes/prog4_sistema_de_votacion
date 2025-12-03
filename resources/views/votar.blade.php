<x-guest-layout>

    <div class="py-10 min-h-screen bg-gradient-to-br from-blue-100 via-indigo-100 to-cyan-100">
        <div class="max-w-3xl mx-auto px-4">

            {{-- Título --}}
            <div class="mb-6 text-center">
                <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                    Votando: {{ $votacion->titulo }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    Elegí una de las opciones disponibles y confirmá tu voto.
                </p>
            </div>

            {{-- Errores generales --}}
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-2xl text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Card principal --}}
            <div class="bg-white shadow-xl rounded-3xl border border-gray-200 p-6 sm:p-8">
                <h1 class="text-xl font-semibold mb-4 text-gray-900">
                    Opciones de votación
                </h1>

                <form method="POST" action="{{ route('voto.store', $votacion->id) }}" class="space-y-4">
                    @csrf

                    {{-- Opciones como tarjetas --}}
                    <div class="space-y-3">
                        @foreach ($votacion->opciones as $opcion)
                            <label class="flex items-center justify-between w-full cursor-pointer
                                           rounded-2xl border border-gray-200 px-4 py-3
                                           hover:border-indigo-400 hover:bg-indigo-50 transition">
                                <div class="flex items-center">
                                    <input
                                        type="radio"
                                        name="opcion_id"
                                        value="{{ $opcion->id }}"
                                        class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    >
                                    <span class="ml-3 text-sm text-gray-800">
                                        {{ $opcion->opcion_disponible }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    {{-- Error específico de opcion_id --}}
                    @error('opcion_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror

                    {{-- UUID oculto --}}
                    <input hidden type="text" name="uuid" id="uuidInput">

                    {{-- Botones --}}
                    <div class="mt-6 flex flex-wrap justify-between gap-3">
                        <a href="javascript:history.back()"
                           class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 text-gray-700
                                  bg-white hover:bg-gray-50 transition">
                            ← Volver
                        </a>

                        <button type="submit"
                                class="px-6 py-2 rounded-xl text-sm font-semibold
                                       bg-indigo-600 hover:bg-indigo-500 text-white shadow-md transition">
                            Votar
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- Script para gestionar UUID del votante --}}
    <script>
        // Verificamos en el localStorage si ya existe un uuid, si no existe lo creamos
        let uuid = localStorage.getItem('uuid');
        if (!uuid) {
            uuid = crypto.randomUUID();
            localStorage.setItem('uuid', uuid);
        }
        // Asignamos el valor del uuid al input hidden
        document.getElementById('uuidInput').value = uuid;
    </script>

</x-guest-layout>
