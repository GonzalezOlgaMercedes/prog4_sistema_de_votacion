<button {{ $attributes->merge([
    'type' => 'button',
    'class' =>
        'inline-flex items-center justify-center px-4 py-2 bg-red-600/90 
        hover:bg-red-500 active:bg-red-700
        border border-transparent rounded-xl
        font-semibold text-sm text-white tracking-wide
        shadow-md hover:shadow-lg
        focus:outline-none focus:ring-2 focus:ring-red-400 
        focus:ring-offset-2 dark:focus:ring-offset-gray-900
        transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
