<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- TÍTULO CORRIGIDO --}}
        <title>Ypy Saúde</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased relative">
        {{-- Fundo branco principal --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-gray-900">
            
            {{-- Conteúdo Central --}}
            <div>
                <a href="/">
                    <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="w-48 h-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        {{-- Barra Azul Esquerda --}}
        <div class="absolute left-0 top-0 bottom-0 w-10 bg-piaui-blue hidden sm:block"></div>

        {{-- Barra Azul Direita --}}
        <div class="absolute right-0 top-0 bottom-0 w-10 bg-piaui-blue hidden sm:block"></div>
    </body>
</html>