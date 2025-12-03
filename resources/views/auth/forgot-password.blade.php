<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">¿Olvidaste tu contraseña?</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
            Ingresá tu email y te enviaremos un enlace para restablecer tu contraseña.
        </p>
    </div>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                          :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Enviar enlace de restablecimiento') }}
            </x-primary-button>
        </div>
    </form>

    <div class="text-center">
        <a href="{{ url()->previous() }}"
           class="inline-flex items-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-300 mt-4">
            ← Volver atrás
        </a>
    </div>

</x-guest-layout>
