{{-- Em resources/views/pages/planos.blade.php --}}
<x-layouts.public>
    <x-slot:title>Planos - Ypy Saúde</x-slot:title>

    <div class="bg-white dark:bg-gray-800 py-12 md:py-20">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-piaui-blue mb-4">Planos Flexíveis para Todos</h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                Escolha o plano que melhor se adapta às suas necessidades. Comece gratuitamente ou aproveite todos os recursos com o plano profissional.
            </p>

            {{-- Grid de Planos --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                
                {{-- CARD PACIENTE --}}
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-8 flex flex-col">
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Paciente</h3>
                    <p class="mt-4 text-4xl font-bold text-piaui-blue">Grátis</p>
                    <p class="text-gray-500 dark:text-gray-400">Para sempre</p>
                    
                    {{-- Lista de funcionalidades do Paciente ATUALIZADA --}}
                    <ul class="mt-6 space-y-3 text-left flex-grow text-gray-700 dark:text-gray-300">
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Acesso ao seu histórico de documentos</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Receitas, atestados e laudos em PDF</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Agendamento de teleconsultas</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Compartilhamento fácil e seguro</li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-8 block w-full text-center px-6 py-3 bg-gray-200 text-gray-800 font-bold rounded-lg hover:bg-gray-300">Cadastre-se</a>
                </div>

                {{-- CARD PLANO PADRÃO (MÉDICO) --}}
                <div class="border-2 border-piaui-blue rounded-lg p-8 flex flex-col relative">
                    <span class="absolute top-0 -translate-y-1/2 left-1/2 -translate-x-1/2 bg-piaui-blue text-white px-3 py-1 text-sm font-bold rounded-full">Mais Popular</span>
                    
                    {{-- Nome do plano ALTERADO --}}
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Plano Padrão</h3>
                    
                    {{-- Preço ALTERADO --}}
                    <p class="mt-4 text-4xl font-bold text-piaui-blue">R$ 59,90<span class="text-lg font-medium text-gray-500 dark:text-gray-400">/mês</span></p>
                    
                    {{-- Lista de funcionalidades do Médico ATUALIZADA --}}
                    <ul class="mt-6 space-y-3 text-left flex-grow text-gray-700 dark:text-gray-300">
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Emissão ilimitada de receitas, atestados e laudos</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Assinatura Digital com validade jurídica</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Cadastro e gestão da carteira de pacientes</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Validação de documentos com QR Code</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Gestão de horários para agendamento</li>
                        <li class="flex items-center"><svg class="w-5 h-5 text-piaui-green mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Suporte prioritário</li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-8 block w-full text-center px-6 py-3 bg-piaui-blue text-white font-bold rounded-lg hover:bg-opacity-90">Assine Agora</a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>