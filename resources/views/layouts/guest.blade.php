<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-800 antialiased bg-rose-50/40">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <div class="text-center">
                <a href="/" class="inline-flex items-center gap-2">
                    <span class="w-12 h-12 rounded-2xl bg-pink-100 text-pink-600 font-bold text-2xl flex items-center justify-center border border-pink-200 shadow-xs">
                        🧺
                    </span>
                    <span class="text-2xl font-extrabold tracking-tight text-gray-800">Laundry <span class="text-pink-500">Express</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-7 py-6 bg-white shadow-sm border border-pink-100 overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
