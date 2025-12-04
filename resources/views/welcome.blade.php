<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-5xl">

            {{-- Header --}}
            <div class="grid grid-cols-4 items-center justify-between mb-8">       
                {{-- Título principal --}}
            <h2 class="text-4xl col-span-3 md:text-5xl font-extrabold mb-4 leading-tight text-gray-900">
                Bienvenido al sistema de votación
            </h2>

                {{-- Botón al panel o login --}}         
                @auth
                    <div class="flex justify-end w-full">
                        <a href="{{ route('dashboard') }}"
                           class="px-5 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-500">
                            Ir al panel
                        </a>
                    </div>
                @else
                    <div class="flex justify-end w-full">
                        <a href="{{ route('login') }}"
                           class="px-5 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-500">
                            Iniciar sesión
                        </a>
                    </div>
                @endauth
            </div>

            

            <p class="text-base md:text-lg mb-6 max-w-xl text-gray-700">
                Creá votaciones, abrílas al público y visualizá los resultados en tiempo real.
            </p>

            {{-- Botones --}}
            @guest
                <div class="flex flex-wrap gap-4 mb-10">
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl shadow-md hover:bg-indigo-500 text-sm">
                        Iniciar sesión como administrador
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-6 py-3 bg-white border border-indigo-300 text-indigo-700 font-semibold rounded-xl shadow-md hover:bg-indigo-50 text-sm">
                        Registrarme
                    </a>
                </div>
            @endguest

            {{-- Votaciones abiertas --}}
            <div class="bg-indigo-50 rounded-2xl p-6 shadow-sm border border-indigo-100 max-w-xl">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">
                    Votaciones abiertas ahora mismo
                </h3>

                
                <div class="space-y-3" id="votaciones-list">
                    @foreach($votaciones as $votacion)
                        <div class="flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-300 transition">
                            <p class="font-semibold text-gray-900 max-w-xs break-words">
                                {{ $votacion->titulo }}
                            </p>

                            <!-- Link de la votación -->
                            <a
                            @if ($votacion->estado == 'cerrada') 
                                hidden
                            @endif
                            
                            id="votar-link-{{ $votacion->id }}" href="{{ route('votar', $votacion->id) }}"
                                class="px-3 py-1.5 bg-emerald-500 text-white rounded-lg text-xs font-semibold hover:bg-emerald-400 shadow">
                                Votar
                            </a>
                            <a
                            @if ($votacion->estado != 'cerrada') 
                                hidden
                            @endif
                            id="resultados-link-{{ $votacion->id }}" href="{{ route('resultados', $votacion->id) }}"
                                class="px-3 py-1.5 bg-emerald-500 text-white rounded-lg text-xs font-semibold hover:bg-emerald-400 shadow">
                                Ver
                            </a>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const uuid = localStorage.getItem('uuid');
                                    if (uuid) {
                                        const votarLink = document.getElementById('votar-link-{{ $votacion->id }}');
                                        votarLink.href += '?uuid=' + encodeURIComponent(uuid);
                                    }
                                });
                            </script>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <template id="votacion-template">
            <div class="flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-300 transition">
                <p class="font-semibold text-gray-900 max-w-xs break-words titulo">
                </p>

                <!-- Link de la votación -->
                <a class="px-3 py-1.5 bg-emerald-500 text-white rounded-lg text-xs font-semibold hover:bg-emerald-400 shadow link-votar"> Votar </a>
                <a class="px-3 py-1.5 bg-emerald-500 text-white rounded-lg text-xs font-semibold hover:bg-emerald-400 shadow link-resultados"> Ver </a>
            </div>
        </template>
    </div>
    {{-- Script que escucha Echo --}}
    @push('scripts')
        @vite('resources/js/welcome-socket.js')
    @endpush

</x-guest-layout>
