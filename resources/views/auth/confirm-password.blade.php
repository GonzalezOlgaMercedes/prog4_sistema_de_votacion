<x-guest-layout>

    <div class="mb-6 text-center">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Confirmá tu contraseña</h2>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            Esta es una zona segura. Ingresá tu contraseña para continuar.
        </p>
    </div>

    <x-input-error :messages="$errors->all()" class="mb-4" />

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="current-password" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Confirmar') }}
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
