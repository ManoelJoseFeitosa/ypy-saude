<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes da Prescrição
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Cabeçalho da Prescrição --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6 text-center">
                        <h3 class="text-2xl font-bold" style="color: #002e7a;">Prescrição Médica</h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            Data de Emissão: {{ \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d/m/Y') }}
                        </div>
                    </div>

                    {{-- Dados do Paciente e Médico --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        {{-- BLOCO DO PACIENTE CORRIGIDO --}}
                        <div>
                            <h4 class="font-bold text-gray-700 dark:text-gray-300">Paciente</h4>
                            <p class="mt-1">{{ $prescricao->paciente->name }}</p> {{-- <-- ESTA LINHA ESTAVA FALTANDO --}}
                            @if($prescricao->paciente->pacienteProfile && $prescricao->paciente->pacienteProfile->cpf)
                                <p class="text-sm text-gray-500">CPF: {{ $prescricao->paciente->pacienteProfile->cpf }}</p>
                            @endif
                        </div>
                        
                        <div class="text-left md:text-right">
                            <h4 class="font-bold text-gray-700 dark:text-gray-300">Médico Responsável</h4>
                            <p class="mt-1">Dr(a). {{ $prescricao->medico->name }}</p>
                            @if($prescricao->medico->medicoProfile)
                                <p class="text-sm text-gray-500">
                                    CRM: {{ $prescricao->medico->medicoProfile->crm }}/{{ $prescricao->medico->medicoProfile->uf_crm }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Lista de Medicamentos --}}
                    <div>
                        <h4 class="font-bold text-lg mb-4 text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-700 pt-4">Medicamentos Prescritos</h4>
                        <div class="space-y-4">
                            @foreach ($prescricao->medicamentos as $index => $medicamento)
                            <div class="p-4 rounded-md bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700">
                                <p class="font-bold text-md" style="color: #002e7a;">{{ $index + 1 }}. {{ $medicamento->nome_medicamento }}</p>
                                <div class="pl-4 mt-2 text-sm text-gray-700 dark:text-gray-300 space-y-1">
                                    <p><span class="font-semibold">Dosagem:</span> {{ $medicamento->dosagem }}</p>
                                    <p><span class="font-semibold">Quantidade:</span> {{ $medicamento->quantidade }}</p>
                                    <p class="mt-1"><span class="font-semibold">Instruções:</span><br>{{ $medicamento->posologia }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('medico.dashboard') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Voltar ao Painel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>