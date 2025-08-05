{{-- Em resources/views/welcome.blade.php --}}
<x-layouts.public>
    {{-- Seção Principal (Hero) --}}
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

    {{-- Nova Seção: O que é o Ypy Saúde e Funcionalidades --}}
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="container mx-auto px-6 py-20">
            <div class="flex flex-wrap items-center">

                {{-- Coluna da Imagem --}}
                <div class="w-full md:w-1/2 px-4 mb-8 md:mb-0">
                    <img src="{{ asset('images/medico-telemedicina.png') }}" alt="Médico realizando um atendimento por telemedicina" class="rounded-lg shadow-2xl w-full">
                </div>

                {{-- Coluna do Texto --}}
                <div class="w-full md:w-1/2 px-4">
                    <h2 class="text-3xl font-bold text-piaui-blue mb-4">O que é o Ypy Saúde?</h2>
                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        O Ypy Saúde é uma plataforma completa de telemedicina projetada para conectar médicos e pacientes no Piauí com segurança e eficiência. Nossa missão é modernizar o acesso à saúde, oferecendo ferramentas digitais que simplificam o dia a dia e garantem a validade e segurança dos documentos médicos.
                    </p>

                    <h3 class="text-2xl font-semibold text-piaui-blue mb-3">Nossas Funcionalidades:</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 dark:text-gray-300">
                        <li>
                            <strong>Prescrições Digitais:</strong> Emita receitas médicas com assinatura digital, validade em todo o território nacional e QR Code para verificação instantânea.
                        </li>
                        <li>
                            <strong>Atestados e Laudos Online:</strong> Gere atestados e laudos médicos de forma rápida e segura, com a mesma validade jurídica de um documento físico e com total conformidade com a LGPD.
                        </li>
                        <li>
                            <strong>Agendamento de Consultas:</strong> Pacientes podem encontrar médicos e agendar teleconsultas diretamente pela plataforma, gerenciando sua saúde com autonomia e praticidade.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

</x-layouts.public>