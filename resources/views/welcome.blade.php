<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ypy Saúde - Prescrições Digitais</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- ALTERAÇÃO 1: Adicionadas as classes flex flex-col min-h-screen --}}
    <body class="antialiased font-sans bg-gray-100 dark:bg-gray-900 flex flex-col min-h-screen">
        <header class="bg-white dark:bg-gray-800 shadow-md">
            <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
                <div>
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="h-16 w-auto">
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-piaui-blue dark:text-gray-300 dark:hover:text-white font-medium">Home</a>
                    <a href="{{ route('planos') }}" class="text-gray-600 hover:text-piaui-blue dark:text-gray-300 dark:hover:text-white font-medium">Planos</a>
                    <a href="{{ route('contato') }}" class="text-gray-600 hover:text-piaui-blue dark:text-gray-300 dark:hover:text-white font-medium">Contato</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-800 dark:text-gray-200 hover:text-piaui-blue dark:hover:text-white font-bold">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-piaui-blue text-white rounded-md hover:bg-opacity-90 font-medium">Registrar</a>
                </div>
            </nav>
        </header>

        {{-- ALTERAÇÃO 2: Adicionada a classe flex-grow --}}
        <main class="flex-grow">
            <section class="bg-white dark:bg-gray-800">
                <div class="container mx-auto px-6 py-20 text-center">
                    <h1 class="text-4xl md:text-5xl font-bold text-piaui-blue mb-4">Ypy Saúde: A Telemedicina do Piauí ao seu alcance.</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                        Uma plataforma moderna e segura para emissão de prescrições médicas digitais. Médicos podem gerar receitas com validação e QR Code, e pacientes podem acessá-las de qualquer lugar, a qualquer hora. Simplificando a saúde com tecnologia.
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('register') }}" class="px-8 py-3 bg-piaui-green text-white font-bold rounded-lg hover:bg-opacity-90 text-lg">Comece a Usar Agora</a>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-piaui-blue text-white">
            <div class="container mx-auto px-6 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-2">
                        <h2 class="font-bold text-xl mb-4">Ypy Saúde</h2>
                        <p class="max-w-md text-gray-300">Simplificando a saúde com tecnologia, diretamente do coração do Piauí para todo o Brasil.</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-4">Navegação</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="hover:underline text-gray-300">Home</a></li>
                            <li><a href="{{ route('planos') }}" class="hover:underline text-gray-300">Planos</a></li>
                            <li><a href="{{ route('contato') }}" class="hover:underline text-gray-300">Contato</a></li>
                            <li><a href="{{ route('login') }}" class="hover:underline text-gray-300">Login</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg mb-4">Contato</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li>contato@ypysaude.com.br</li>
                            <li>(86) 99999-9999</li>
                            <li>Teresina, Piauí</li>
                        </ul>
                        <div class="flex space-x-4 mt-4">
                            <a href="#" class="text-gray-300 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="#" class="text-gray-300 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.85s-.011 3.584-.069 4.85c-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07s-3.584-.012-4.85-.07c-3.252-.148-4.771-1.691-4.919-4.919-.058-1.265-.069-1.645-.069-4.85s.011-3.584.069-4.85c.149-3.225 1.664-4.771 4.919-4.919 1.266-.058 1.644-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.059-1.281.073-1.689.073-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.281-.059-1.689-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4s1.791-4 4-4 4 1.79 4 4-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.644-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.644 1.439-1.44s-.644-1.44-1.439-1.44z" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-10 border-t border-gray-700 pt-8 text-center text-sm text-gray-400">
                    <p>&copy; {{ date('Y') }} Ypy Saúde. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>
    </body>
</html>