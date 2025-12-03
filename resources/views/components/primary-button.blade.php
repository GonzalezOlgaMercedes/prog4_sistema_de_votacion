<button {{ $attributes->merge([
    'type' => 'submit',
    'class' =>
        'inline-flex items-center justify-center px-4 py-2 bg-indigo-600/90 
        hover:bg-indigo-500 active:bg-indigo-700
        border border-transparent rounded-xl
        font-semibold text-sm text-white tracking-wide
        shadow-md hover:shadow-lg
        focus:outline-none focus:ring-2 focus:ring-indigo-400 
        focus:ring-offset-2 dark:focus:ring-offset-gray-900
        transition ease-in-out duration-150'
]) }}>
    {{ $slot }}
</button>
