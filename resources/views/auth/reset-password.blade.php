<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Restablecer Contraseña</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Ingresá tu nueva contraseña para recuperar el acceso a tu cuenta.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email"
                          name="email" :value="old('email', $request->email)"
                          required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Nueva Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password"
                          name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Restablecer Contraseña') }}
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
