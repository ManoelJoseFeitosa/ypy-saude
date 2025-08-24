<x-guest-layout>
    {{-- Seção Principal (Hero) --}}
    <section class="bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6 py-16 md:py-24">
            <div class="flex flex-col md:flex-row items-center gap-12">
                {{-- Textos e CTA --}}
                <div class="w-full md:w-1/2 text-center md:text-left">
                    <h1 class="text-4xl lg:text-5xl font-bold text-blue-900 dark:text-white leading-tight mb-4">
                        Ypy Saúde: A Telemedicina do Piauí ao seu alcance.
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 max-w-xl mx-auto md:mx-0 mb-8">
                        Uma plataforma moderna e segura para emissão de prescrições, laudos e atestados digitais. Simplificando a saúde com tecnologia.
                    </p>
                    <a href="{{ route('register') }}" class="px-10 py-4 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 text-lg transition-colors shadow-lg">
                        Comece a Usar Agora
                    </a>
                </div>
                {{-- Imagem Ilustrativa --}}
                <div class="w-full md:w-1/2 mt-8 md:mt-0">
                    <img src="{{ asset('images/medico-telemedicina.png') }}" alt="Médico em atendimento por telemedicina" class="rounded-lg shadow-2xl w-full">
                </div>
            </div>
        </div>
    </section>

    {{-- Seção de Funcionalidades (fundo amarelo) --}}
    <section class="bg-yellow-50 dark:bg-gray-900 border-t border-b border-yellow-200">
        <div class="container mx-auto px-6 py-20 text-center">
            <h2 class="text-3xl font-bold text-blue-900 mb-2">Uma Plataforma Completa</h2>
            <p class="text-gray-600 mb-12 max-w-2xl mx-auto">Tudo que você precisa para modernizar seu atendimento e cuidar da sua saúde.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1: Prescrições --}}
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <h3 class="text-xl font-bold text-green-600 mb-3">Prescrições Digitais</h3>
                    <p class="text-gray-700">
                        Emita receitas com assinatura digital, QR Code e validade nacional de forma rápida e segura.
                    </p>
                </div>
                {{-- Card 2: Atestados e Laudos --}}
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <h3 class="text-xl font-bold text-green-600 mb-3">Atestados e Laudos</h3>
                    <p class="text-gray-700">
                        Gere documentos médicos com a mesma validade jurídica de um documento físico, em conformidade com a LGPD.
                    </p>
                </div>
                {{-- Card 3: Agendamento --}}
                <div class="bg-white p-8 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <h3 class="text-xl font-bold text-green-600 mb-3">Agendamento de Consultas</h3>
                    <p class="text-gray-700">
                        Pacientes encontram médicos e agendam teleconsultas diretamente pela plataforma com praticidade.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
