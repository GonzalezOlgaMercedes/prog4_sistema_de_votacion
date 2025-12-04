<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-5xl">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-gray-800">
                    Sistema de Votación en Tiempo Real
                </h1>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-5 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-500">
                        Ir al panel
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-5 py-2 text-sm font-semibold bg-indigo-600 text-white rounded-xl shadow-md hover:bg-indigo-500">
                        Iniciar sesión
                    </a>
                @endauth
            </div>

            {{-- Título principal --}}
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight text-gray-900">
                Bienvenido al sistema<br>de votación
            </h2>

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

                @if($votaciones->isEmpty())
                    <p class="text-sm text-gray-600">
                        Actualmente no hay votaciones abiertas.
                    </p>
                @else
                    <div class="space-y-3">
                        @foreach($votaciones as $votacion)
                            <div class="flex items-center justify-between bg-white px-4 py-3 rounded-xl border border-gray-200 hover:border-indigo-300 transition">
                                <p class="font-semibold text-gray-900">
                                    {{ $votacion->titulo }}
                                </p>

                                <!-- Link de la votación -->
                                <a id="votar-link-{{ $votacion->id }}" href="{{ route('votar', $votacion->id) }}"
                                   class="px-3 py-1.5 bg-emerald-500 text-white rounded-lg text-xs font-semibold hover:bg-emerald-400 shadow">
                                    Votar
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
                @endif
            </div>

        </div>
    </div>

</x-guest-layout>
