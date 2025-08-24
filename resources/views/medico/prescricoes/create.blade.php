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
                    <form method="POST" action="{{ route('medico.prescricoes.store') }}" x-data="prescricaoForm()">
                        @csrf

                        {{-- Paciente e Tipo de Receita --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="paciente_id" value="Selecione o Paciente" />
                                <select id="paciente_id" name="paciente_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    @foreach($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="tipo" value="Modelo de Receita" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
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
                                <div class="p-4 border rounded-lg relative">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        {{-- Campo Nome do Medicamento com Autocomplete --}}
                                        <div class="md:col-span-2 relative">
                                            <x-input-label ::for="'medicamento_nome_' + index" value="Nome do Medicamento" />
                                            <x-text-input ::id="'medicamento_nome_' + index" ::name="`medicamentos[${index}][nome_medicamento]`" x-model="medicamento.nome_medicamento" @input.debounce.300ms="buscarMedicamentos(index)" @blur="setTimeout(() => { sugestoes[index] = [] }, 200)" class="mt-1 block w-full" required autocomplete="off" />
                                            {{-- Div para mostrar as sugestões --}}
                                            <div x-show="sugestoes[index] && sugestoes[index].length > 0" class="absolute z-10 w-full bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-md mt-1 max-h-48 overflow-y-auto shadow-lg">
                                                <template x-for="sugestao in sugestoes[index]" :key="sugestao">
                                                    <a href="#" @click.prevent="selecionarSugestao(index, sugestao)" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800" x-text="sugestao"></a>
                                                </template>
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label ::for="'dosagem_' + index" value="Dosagem (ex: 500mg)" />
                                            <x-text-input ::id="'dosagem_' + index" ::name="`medicamentos[${index}][dosagem]`" x-model="medicamento.dosagem" class="mt-1 block w-full" required />
                                        </div>
                                        <div>
                                            <x-input-label ::for="'quantidade_' + index" value="Quantidade (ex: 1 caixa)" />
                                            <x-text-input ::id="'quantidade_' + index" ::name="`medicamentos[${index}][quantidade]`" x-model="medicamento.quantidade" class="mt-1 block w-full" required />
                                        </div>
                                        <div class="md:col-span-2">
                                            <x-input-label ::for="'posologia_' + index" value="Posologia (instruções de uso)" />
                                            <textarea ::id="'posologia_' + index" ::name="`medicamentos[${index}][posologia]`" x-model="medicamento.posologia" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required></textarea>
                                        </div>
                                    </div>
                                    <button type="button" @click="removerMedicamento(index)" x-show="medicamentos.length > 1" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
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

    <script>
        function prescricaoForm() {
            return {
                medicamentos: [{ nome_medicamento: '', dosagem: '', quantidade: '', posologia: '' }],
                sugestoes: [[]], // Array para guardar sugestões para cada medicamento
                adicionarMedicamento() {
                    this.medicamentos.push({ nome_medicamento: '', dosagem: '', quantidade: '', posologia: '' });
                    this.sugestoes.push([]);
                },
                removerMedicamento(index) {
                    this.medicamentos.splice(index, 1);
                    this.sugestoes.splice(index, 1);
                },
                buscarMedicamentos(index) {
                    const termo = this.medicamentos[index].nome_medicamento;
                    if (termo.length < 3) {
                        this.sugestoes[index] = [];
                        return;
                    }
                    fetch(`{{ route('medico.api.medicamentos.search') }}?q=${termo}`)
                        .then(response => response.json())
                        .then(data => {
                            this.sugestoes[index] = data;
                        })
                        .catch(error => console.error('Erro:', error));
                },
                selecionarSugestao(index, sugestao) {
                    this.medicamentos[index].nome_medicamento = sugestao;
                    this.sugestoes[index] = [];
                }
            }
        }
    </script>
</x-app-layout>
