<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Ypy Saúde' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    {{-- Estrutura de Grid que força o rodapé para o final da página --}}
    <div class="grid grid-rows-[auto_1fr_auto] min-h-screen bg-gray-50 dark:bg-gray-900">
        
        {{-- CABEÇALHO --}}
        <header class="bg-blue-800 shadow-lg sticky top-0 z-50">
            <nav x-data="{ open: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    {{-- Logo --}}
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="block h-14 w-auto">
                        </a>
                    </div>

                    {{-- Navegação Desktop --}}
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('login') }}" class="text-white font-medium hover:text-yellow-300 transition duration-150 ease-in-out">Entrar</a>
                        <a href="{{ route('register') }}" class="inline-block bg-green-500 text-white font-bold py-2 px-5 rounded-lg hover:bg-green-600 transition duration-150 ease-in-out shadow-sm">
                            Criar Conta
                        </a>
                    </div>

                    {{-- Botão Hamburger (Mobile) --}}
                    <div class="md:hidden flex items-center">
                        <button @click="open = !open" class="text-white focus:outline-none">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Menu Mobile --}}
                <div x-show="open" @click.away="open = false" class="md:hidden pb-4">
                    <a href="{{ route('login') }}" class="block text-white py-2 px-3 rounded hover:bg-blue-700">Entrar</a>
                    <a href="{{ route('register') }}" class="block mt-2 bg-green-500 text-white text-center font-bold py-2 px-5 rounded-lg hover:bg-green-600 transition duration-150 ease-in-out">
                        Criar Conta
                    </a>
                </div>
            </nav>
        </header>

        {{-- CONTEÚDO PRINCIPAL (ocupa todo o espaço restante) --}}
        <main>
            {{ $slot }}
        </main>

        {{-- RODAPÉ --}}
        <footer class="bg-blue-900 text-white">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h3 class="font-bold text-lg text-yellow-300">Ypy Saúde</h3>
                    <p class="text-sm text-blue-200 mt-2">Simplificando a saúde com tecnologia, diretamente do coração do Piauí para todo o Brasil.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-yellow-300">Navegação</h3>
                    <ul class="mt-2 space-y-1 text-sm">
                        <li><a href="{{ route('home') }}" class="text-blue-200 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white">Planos</a></li>
                        <li><a href="#" class="text-blue-200 hover:text-white">Contato</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-yellow-300">Contato</h3>
                    <address class="mt-2 space-y-1 text-sm not-italic text-blue-200">
                        <p>contato@ypysaude.com.br</p>
                        <p>Teresina, Piauí</p>
                    </address>
                </div>
            </div>
            <div class="border-t border-blue-800 mt-8 py-4">
                <p class="text-center text-sm text-blue-300">&copy; {{ date('Y') }} Ypy Saúde. Todos os direitos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>
