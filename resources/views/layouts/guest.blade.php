<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ypy Saúde</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased relative">
    
    {{-- Barras Laterais Azuis (visíveis apenas em ecrãs maiores) --}}
    <div class="absolute left-0 top-0 bottom-0 w-10 bg-blue-800 hidden sm:block"></div>
    <div class="absolute right-0 top-0 bottom-0 w-10 bg-blue-800 hidden sm:block"></div>

    <div class="min-h-screen bg-white dark:bg-gray-900">
        <!-- Navegação -->
        <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
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
            {{-- Seção Principal (Hero) --}}
            <section class="bg-white dark:bg-gray-800">
                <div class="container mx-auto px-6 py-20 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-4">Ypy Saúde: A Telemedicina do Piauí ao seu alcance.</h1>
                    
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Uma plataforma moderna e segura para emissão de prescrições médicas digitais. Médicos podem gerar receitas com validação e QR Code, e pacientes podem acessá-las de qualquer lugar, a qualquer hora. Simplificando a saúde com tecnologia.
                    </p>
                    
                    <div class="mt-8">
                        <a href="{{ route('planos') }}" class="px-8 py-3 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 text-lg transition-colors">Comece a Usar Agora</a>
                    </div>
                </div>
            </section>

            {{-- Seção de Funcionalidades --}}
            <section class="bg-gray-50 dark:bg-gray-900">
                <div class="container mx-auto px-6 py-20">
                    <div class="flex flex-col md:flex-row items-center gap-12">
                        <div class="w-full md:w-1/2">
                            <img src="{{ asset('images/medico-telemedicina.png') }}" alt="Médico a realizar um atendimento por telemedicina" class="rounded-lg shadow-2xl w-full">
                        </div>
                        <div class="w-full md:w-1/2">
                            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">O que é o Ypy Saúde?</h2>
                            <p class="text-gray-700 dark:text-gray-300 mb-6 text-lg text-justify">
                                O Ypy Saúde é uma plataforma completa de telemedicina projetada para conectar médicos e pacientes no Piauí com segurança e eficiência. Nossa missão é modernizar o acesso à saúde, oferecendo ferramentas digitais que simplificam o dia a dia e garantem a validade e segurança dos documentos médicos.
                            </p>
                            <h3 class="text-2xl font-semibold text-gray-800 dark:text-white mb-3">Nossas Funcionalidades:</h3>
                            <ul class="list-disc list-inside space-y-3 text-gray-700 dark:text-gray-300">
                                <li class="text-lg text-justify">
                                    <strong>Prescrições Digitais:</strong> Emita receitas médicas com assinatura digital, validade em todo o território nacional e QR Code para verificação instantânea.
                                </li>
                                <li class="text-lg text-justify">
                                    <strong>Atestados e Laudos Online:</strong> Gere atestados e laudos médicos de forma rápida e segura, com a mesma validade jurídica de um documento físico e com total conformidade com a LGPD.
                                </li>
                                <li class="text-lg text-justify">
                                    <strong>Agendamento de Consultas:</strong> Pacientes podem encontrar médicos e agendar teleconsultas diretamente pela plataforma, gerenciando sua saúde com autonomia e praticidade.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Rodapé Corrigido -->
        <footer class="bg-blue-200">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                <div>
                    <h3 class="font-bold text-lg text-blue-900">Ypy Saúde</h3>
                    <p class="text-sm text-blue-800 mt-2">Simplificando a saúde com tecnologia, diretamente do coração do Piauí para todo o Brasil.</p>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-blue-900">Navegação</h3>
                    <ul class="mt-2 space-y-1 text-sm">
                        <li><a href="{{ route('home') }}" class="text-blue-800 hover:text-blue-950">Home</a></li>
                        <li><a href="{{ route('planos') }}" class="text-blue-800 hover:text-blue-950">Planos</a></li>
                        <li><a href="{{ route('contato') }}" class="text-blue-800 hover:text-blue-950">Contato</a></li>
                        <li><a href="{{ route('login') }}" class="text-blue-800 hover:text-blue-950">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-blue-900">Contato</h3>
                    <address class="mt-2 space-y-1 text-sm not-italic text-blue-800">
                        <p>contato@ypysaude.com.br</p>
                        <p>(86) 99999-9999</p>
                        <p>Teresina, Piauí</p>
                    </address>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
