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
                <h1 class="text-2xl font-bold mb-4">Lista de Votaciones</h1>
                <table class="min-w-full bg-white dark:bg-gray-700">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">ID</th>
                            <th class="py-2 px-4 border-b">Título</th>
                            <th class="py-2 px-4 border-b">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($votaciones as $votacion)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $votacion->id }}</td>
                                <td class="py-2 px-4 border-b">{{ $votacion->titulo }}</td>
                                <td class="py-2 px-4 border-b">{{ $votacion->estado }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
