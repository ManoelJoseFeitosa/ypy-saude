<x-layouts.public>
    <x-slot:title>Validação de Documento - Ypy Saúde</x-slot:title>

    <div class="bg-gray-50 dark:bg-gray-900 py-12 md:py-20">
        <div class="container mx-auto px-6 max-w-2xl">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 border border-gray-200 dark:border-gray-700">
                
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full mb-4">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Documento Válido e Autêntico</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-2">Este documento foi gerado e assinado digitalmente através da plataforma Ypy Saúde.</p>
                </div>

                <div class="border-t border-gray-200 dark:border-gray-700 pt-6 space-y-4">
                    <div>
                        <h3 class="font-semibold text-gray-600 dark:text-gray-300">Tipo de Documento:</h3>
                        <p class="text-gray-800 dark:text-white text-lg capitalize">{{ $tipo }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-600 dark:text-gray-300">Data de Emissão:</h3>
                        <p class="text-gray-800 dark:text-white text-lg">
                            @if($tipo === 'prescricao')
                                {{ \Carbon\Carbon::parse($documento->data_prescricao)->format('d/m/Y \à\s H:i') }}
                            @else
                                {{ \Carbon\Carbon::parse($documento->data_emissao)->format('d/m/Y \à\s H:i') }}
                            @endif
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-600 dark:text-gray-300">Médico Responsável:</h3>
                        <p class="text-gray-800 dark:text-white text-lg">{{ $documento->medico->name }}</p>
                        <p class="text-gray-500 dark:text-gray-400">CRM: {{ $documento->medico->medicoProfile->crm }} / {{ $documento->medico->medicoProfile->uf_crm }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-600 dark:text-gray-300">Paciente:</h3>
                        <p class="text-gray-800 dark:text-white text-lg">{{ $documento->paciente->name }}</p>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <a href="https://validar.iti.gov.br" target="_blank" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                        Verificar no Validador Oficial do Governo Federal (ITI)
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-layouts.public>
