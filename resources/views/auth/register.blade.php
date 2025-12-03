<x-guest-layout>

    <div class="mb-4 text-center">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            Crear cuenta
        </h2>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Registrate para gestionar y participar en votaciones.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-1">
            <x-primary-button class="w-full justify-center">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>

        <div class="flex flex-col items-center gap-1 text-[11px] text-gray-500 dark:text-gray-400">
            <div>
                ¿Ya tenés cuenta?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                    Iniciá sesión
                </a>
            </div>

            <a href="{{ route('login') }}"
               class="inline-flex items-center hover:text-gray-300">
                ← Volver al inicio
            </a>
        </div>

    </form>

</x-guest-layout>
