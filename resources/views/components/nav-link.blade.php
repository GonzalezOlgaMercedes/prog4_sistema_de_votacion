@props(['active'])

@php
$classes = $active
    ? 'inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-300
       border-b-2 border-indigo-400'
    : 'inline-flex items-center px-3 py-2 text-sm font-medium text-slate-300
       border-b-2 border-transparent hover:border-slate-500 hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
