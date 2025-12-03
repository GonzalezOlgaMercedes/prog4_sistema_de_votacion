<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-blue-600 via-indigo-600 to-cyan-500">
    <div class="min-h-screen flex flex-col items-center justify-center p-6">

        {{-- CONTENIDO DE CADA PANTALLA (login, register, welcome, votar, etc.) --}}
        <div class="w-full max-w-4xl">

            <div class="bg-white/95 rounded-3xl shadow-2xl border border-white/30 p-6 md:p-10">
                {{ $slot }}
            </div>

        </div>

    </div>
</body>
</html>
