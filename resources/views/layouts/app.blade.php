<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full">
<div>
    @include('layouts.navigation')

    <div class="lg:pl-72 pb-8">
        <div @class(['max-w-7xl px-4 sm:px-6 lg:px-8', 'py-8' => !isset($header)])>
            @if (isset($header))
                <header class="sticky top-0 bg-slate-50 py-8 z-50 -mx-1 px-1">
                    {{ $header }}
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</div>
</body>
</html>
