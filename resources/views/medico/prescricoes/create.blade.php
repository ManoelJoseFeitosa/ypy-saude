<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Nova Prescrição Médica
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('medico.prescricoes.store') }}" x-data="prescricaoForm()" @tom-select-init.window="initTomSelect($event.detail)">
                        @csrf

                        {{-- Paciente e Tipo de Receita --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="paciente_id" value="Selecione o Paciente" />
                                <select id="paciente_id" name="paciente_id" class="mt-1 block w-full" required>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="tipo" value="Modelo de Receita" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full" required>
                                    <option value="simples">Receita Simples</option>
                                    <option value="especial">Receita de Controle Especial</option>
                                    <option value="amarela">Receita Amarela (A)</option>
                                    <option value="azul">Receita Azul (B)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Medicamentos --}}
                        <h3 class="text-lg font-semibold border-t pt-6 mb-4">Medicamentos</h3>
                        <div class="space-y-4">
                            <template x-for="(medicamento, index) in medicamentos" :key="index">
                                <div class="p-4 border dark:border-gray-600 rounded-lg relative">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <x-input-label ::for="'medicamento_nome_' + index" value="Nome do Medicamento" />
                                            {{-- O input agora é um select que será transformado pelo Tom Select --}}
                                            <select ::id="'medicamento_nome_' + index" ::name="`medicamentos[${index}][nome_medicamento]`" x-init="$nextTick(() => { $dispatch('tom-select-init', { element: $el }) })">
                                                <option value="">Digite para buscar...</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label ::for="'dosagem_' + index" value="Dosagem (ex: 500mg)" />
                                            <x-text-input ::id="'dosagem_' + index" ::name="`medicamentos[${index}][dosagem]`" class="mt-1 block w-full" required />
                                        </div>
                                        <div>
                                            <x-input-label ::for="'quantidade_' + index" value="Quantidade (ex: 1 caixa)" />
                                            <x-text-input ::id="'quantidade_' + index" ::name="`medicamentos[${index}][quantidade]`" class="mt-1 block w-full" required />
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label ::for="'posologia_' + index" value="Posologia (instruções de uso)" />
                                            <textarea ::id="'posologia_' + index" ::name="`medicamentos[${index}][posologia]`" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required></textarea>
                                        </div>
                                    </div>
                                    <button type="button" @click="removerMedicamento(index)" x-show="medicamentos.length > 1" class="absolute top-2 right-2 text-red-500 hover:text-red-700 font-bold text-xl">
                                        &times;
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div class="flex items-center justify-between mt-6">
                            <button type="button" @click="adicionarMedicamento()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">+ Adicionar</button>
                            <x-primary-button>Gerar Prescrição</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function prescricaoForm() {
            return {
                medicamentos: [{}], // Começa com um objeto vazio
                tomSelectInstances: [], // Guarda as instâncias do TomSelect

                init() {
                    // Inicializa o primeiro campo de medicamento
                    this.$nextTick(() => {
                        const firstElement = document.getElementById('medicamento_nome_0');
                        if (firstElement) {
                            this.initTomSelect({ element: firstElement });
                        }
                    });
                },

                adicionarMedicamento() {
                    this.medicamentos.push({});
                },

                removerMedicamento(index) {
                    // Remove a instância do TomSelect antes de remover o elemento do DOM
                    if (this.tomSelectInstances[index]) {
                        this.tomSelectInstances[index].destroy();
                        this.tomSelectInstances.splice(index, 1);
                    }
                    this.medicamentos.splice(index, 1);
                },

                initTomSelect({ element }) {
                    const index = parseInt(element.id.split('_').pop());
                    const instance = new TomSelect(element, {
                        valueField: 'value',
                        labelField: 'text',
                        searchField: 'text',
                        create: true, // Permite que o médico digite um nome que não está na lista
                        load: function(query, callback) {
                            if (query.length < 3) return callback();
                            fetch(`{{ route('medico.api.medicamentos.search') }}?q=${encodeURIComponent(query)}`)
                                .then(response => response.json())
                                .then(json => {
                                    callback(json.items);
                                }).catch(() => {
                                    callback();
                                });
                        },
                        render: {
                            no_results: function(data, escape) {
                                return '<div class="no-results">Nenhum resultado encontrado.</div>';
                            },
                        }
                    });
                    this.tomSelectInstances[index] = instance;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
