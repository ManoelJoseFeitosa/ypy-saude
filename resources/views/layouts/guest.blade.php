<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Ypy Saúde' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        <!-- Navegação -->
        <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('home') }}">
                                <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="block h-12 w-auto">
                            </a>
                        </div>
                    </div>

                    <!-- Links de Navegação (Desktop) -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-8">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">Log in</a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Registrar</a>
                    </div>

                    <!-- Botão Hambúrguer (Mobile) -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu Responsivo (Mobile) -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Registrar') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </nav>

        <!-- Conteúdo da Página -->
        <main>
            {{ $slot }}
        </main>

        <!-- Rodapé -->
        <footer class="bg-blue-800 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h3 class="font-bold text-lg">Ypy Saúde</h3>
                    <p class="text-sm text-blue-200 mt-2">Simplificando a saúde com tecnologia, diretamente do coração do Piauí para todo o Brasil.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Navegação</h3>
                    <ul class="mt-2 space-y-1 text-sm">
                        <li><a href="{{ route('home') }}" class="text-blue-200 hover:text-white">Home</a></li>
                        <li><a href="{{ route('planos') }}" class="text-blue-200 hover:text-white">Planos</a></li>
                        <li><a href="{{ route('contato') }}" class="text-blue-200 hover:text-white">Contato</a></li>
                        <li><a href="{{ route('login') }}" class="text-blue-200 hover:text-white">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg">Contato</h3>
                    <address class="mt-2 space-y-1 text-sm not-italic text-blue-200">
                        <p>contato@ypysaude.com.br</p>
                        <p>(86) 99950-3815</p>
                        <p>Teresina, Piauí</p>
                    </address>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
