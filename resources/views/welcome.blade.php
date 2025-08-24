<x-guest-layout>
    {{-- Secção Principal (Hero) --}}
    <div class="bg-blue-700 text-white">
        <div class="container mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight">Ypy Saúde: A Telemedicina do Piauí ao seu alcance.</h1>
            <p class="mt-4 text-lg md:text-xl text-blue-200 max-w-3xl mx-auto">
                Uma plataforma moderna e segura para emissão de prescrições médicas digitais. Médicos podem gerar receitas com validação e QR Code, e pacientes podem acessá-las de qualquer lugar, a qualquer hora. Simplificando a saúde com tecnologia.
            </p>
            <a href="{{ route('register') }}" class="mt-8 inline-block bg-green-500 text-white font-bold py-3 px-8 rounded-lg hover:bg-green-600 transition duration-300">
                Comece a Usar Agora
            </a>
        </div>
    </div>

    {{-- Secção de Funcionalidades --}}
    <div class="bg-white dark:bg-gray-800 py-20">
        <div class="container mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white">Nossas Funcionalidades</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Ferramentas digitais que simplificam o dia a dia e garantem a segurança.</p>
            </div>

            {{-- Item de Funcionalidade 1 --}}
            <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12 mb-16">
                <div class="w-full md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=2070" alt="Médico em teleconsulta" class="rounded-lg shadow-lg">
                </div>
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Prescrições Digitais</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Emita receitas médicas com assinatura digital, validade em todo o território nacional e QR Code para verificação rápida e segura em qualquer farmácia.
                    </p>
                </div>
            </div>

            {{-- Item de Funcionalidade 2 (invertido) --}}
            <div class="flex flex-col-reverse md:flex-row items-center gap-8 md:gap-12">
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Agendamento de Teleconsultas</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Pacientes podem encontrar médicos e agendar teleconsultas diretamente pela plataforma, de forma simples e intuitiva. Uma agenda completa para médicos e pacientes.
                    </p>
                </div>
                <div class="w-full md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?q=80&w=2070" alt="Paciente usando o celular" class="rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
