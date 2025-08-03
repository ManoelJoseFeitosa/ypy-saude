    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Prontuário de: {{ $paciente->name }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                {{-- Formulário para Nova Anotação --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Nova Anotação no Prontuário</h3>
                        <form action="{{ route('medico.pacientes.prontuario.store', $paciente) }}" method="POST">
                            @csrf
                            <textarea name="anotacao" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required></textarea>
                            <div class="mt-4 flex justify-end">
                                <x-primary-button>Salvar Anotação</x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Histórico do Prontuário --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Histórico de Atendimentos</h3>
                        <div class="space-y-4">
                            @forelse ($paciente->prontuarios as $registro)
                                <div class="border-l-4 border-piaui-blue pl-4 py-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $registro->data_atendimento->format('d/m/Y') }} - Dr(a). {{ $registro->medico->name }}
                                    </p>
                                    <p class="mt-1">{{ $registro->anotacao }}</p>
                                </div>
                            @empty
                                <p class="text-gray-500">Nenhum registro no prontuário ainda.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Histórico de Prescrições e Atestados (opcional) --}}

            </div>
        </div>
    </x-app-layout>
    