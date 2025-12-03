@props(['id', 'maxWidth' => '2xl'])

@php
$maxWidthClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="{ show: false }"
    x-on:open-modal.window="if ($event.detail.id === '{{ $id }}') show = true"
    x-on:close-modal.window="if ($event.detail.id === '{{ $id }}') show = false"
    x-show="show"
    x-transition.opacity
    class="fixed inset-0 z-40 flex items-center justify-center"
    style="display: none;"
>
    <!-- Fondo -->
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>

    <!-- Contenido -->
    <div
        x-show="show"
        x-transition
        class="relative z-50 w-full {{ $maxWidthClass }} mx-auto px-4"
    >
        <div class="bg-slate-900 border border-slate-700/60 rounded-2xl shadow-2xl p-6">
            {{ $slot }}
        </div>
    </div>
</div>
