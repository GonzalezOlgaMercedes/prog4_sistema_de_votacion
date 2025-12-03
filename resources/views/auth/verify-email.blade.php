<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Verificá tu Email</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
            Antes de continuar, necesitamos que confirmes tu dirección de correo electrónico.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400 text-center">
            {{ __('Te enviamos un nuevo enlace de verificación a tu correo.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col items-center space-y-4">

        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <x-primary-button class="w-full justify-center">
                {{ __('Reenviar Email de Verificación') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-300 underline">
                {{ __('Cerrar Sesión') }}
            </button>
        </form>

        <a href="{{ url()->previous() }}"
           class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-300 mt-2">
            ← Volver atrás
        </a>

    </div>

</x-guest-layout>
