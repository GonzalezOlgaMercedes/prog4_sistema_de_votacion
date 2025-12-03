@props(['value'])

<label {{ $attributes->merge([
    'class' =>
        'block text-xs font-semibold tracking-wide 
        text-gray-300 dark:text-gray-300 uppercase'
]) }}>
    {{ $value ?? $slot }}
</label>
