<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ypy Saúde - Telemedicina no Piauí</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- ADICIONADA A CLASSE 'relative' PARA POSICIONAR AS BARRAS --}}
    <body class="font-sans antialiased relative">
        {{-- ADICIONADA MARGEM HORIZONTAL 'sm:mx-10' PARA NÃO FICAR ATRÁS DAS BARRAS --}}
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 sm:mx-10">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- Barra Azul Esquerda --}}
        <div class="absolute left-0 top-0 bottom-0 w-10 bg-piaui-blue hidden sm:block"></div>

        {{-- Barra Azul Direita --}}
        <div class="absolute right-0 top-0 bottom-0 w-10 bg-piaui-blue hidden sm:block"></div>
    </body>
</html>