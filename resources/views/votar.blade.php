<x-guest-layout>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Votando: {{ $votacion->titulo }}
        </h2>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Opciones de Votación</h1>
                    <form method="POST" action="{{ route('voto.store', $votacion->id) }}">
                        @csrf
                        @foreach ($votacion->opciones as $opcion)
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="opcion_id" value="{{ $opcion->id }}" class="form-radio">
                                    <span class="ml-2">{{ $opcion->opcion_disponible }}</span>
                                </label>
                            </div>
                        @endforeach

                        <!-- Este script recupera o genera la uuid para identificar al usuario -->
                        <input hidden type="text" name="uuid" id="uuidInput">
                        <script>
                            //Verificamos en el localStorage si ya existe un uuid, si no existe lo creamos
                            let uuid = localStorage.getItem('uuid');
                            if (!uuid) {
                                uuid = crypto.randomUUID();
                                localStorage.setItem('uuid', uuid);
                            }
                            //Asignamos el valor del uuid al input hidden
                            document.getElementById('uuidInput').value = uuid;
                        </script>


                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Votar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            </div>
        @endif
</x-guest-layout>