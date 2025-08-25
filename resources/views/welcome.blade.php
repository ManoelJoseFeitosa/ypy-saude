<x-guest-layout>
    {{-- Seção Principal (Hero) --}}
    <section class="bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6 py-16 md:py-24 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-blue-900 dark:text-white leading-tight mb-4 max-w-3xl mx-auto">
                Ypy Saúde: A Telemedicina do Piauí ao seu alcance.
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-8">
                Uma plataforma moderna e segura para emissão de prescrições, laudos e atestados digitais. Simplificando a saúde com tecnologia.
            </p>
            <a href="{{ route('register') }}" class="px-10 py-4 bg-green-500 text-white font-bold rounded-lg hover:bg-green-600 text-lg transition-colors shadow-lg">
                Comece a Usar Agora
            </a>
        </div>
    </section>

    {{-- Seção de Funcionalidades --}}
    <section class="bg-gray-100 dark:bg-gray-900 py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-blue-900 mb-12">Uma Plataforma Completa para Médicos e Pacientes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1: Prescrições --}}
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-green-600 mb-3">Prescrições Digitais</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Emita receitas com assinatura digital, QR Code e validade nacional de forma rápida e segura.
                    </p>
                </div>
                {{-- Card 2: Atestados e Laudos --}}
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-green-600 mb-3">Atestados e Laudos</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Gere documentos com a mesma validade jurídica de um documento físico, em conformidade com a LGPD.
                    </p>
                </div>
                {{-- Card 3: Agendamento --}}
                <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
                    <h3 class="text-xl font-bold text-green-600 mb-3">Agendamento de Consultas</h3>
                    <p class="text-gray-700 dark:text-gray-300">
                        Pacientes encontram médicos e agendam teleconsultas diretamente pela plataforma com praticidade.
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>
