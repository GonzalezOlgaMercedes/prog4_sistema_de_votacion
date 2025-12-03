@props(['active' => false])

@php
$classes = $active
    ? 'block px-4 py-2 text-sm text-indigo-300 bg-slate-800'
    : 'block px-4 py-2 text-sm text-slate-200 hover:bg-slate-800 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
