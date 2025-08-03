    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Nova Prescrição') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                        
                        <form method="POST" action="{{ route('medico.prescricoes.store') }}">
                            @csrf

                            <!-- Seletor de Paciente -->
                            <div>
                                <x-input-label for="paciente_id" :value="__('Selecione o Paciente')" />
                                <select name="paciente_id" id="paciente_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">-- Selecione um paciente --</option>
                                    @foreach ($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}" @selected(old('paciente_id') == $paciente->id)>
                                            {{ $paciente->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('paciente_id')" class="mt-2" />
                            </div>

                            <hr class="my-8 border-gray-300 dark:border-gray-700">

                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Medicamentos</h3>
                                <button type="button" id="add-medicamento-btn" class="px-3 py-1 bg-green-600 text-white rounded-md text-sm hover:bg-green-700" style="background-color: #00995D;">+ Adicionar</button>
                            </div>

                            <div id="medicamentos-container" class="space-y-6">
                                {{-- Bloco de Medicamento 1 (template) --}}
                                <div class="medicamento-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg space-y-4">
                                    {{-- CAMPO DE BUSCA DE MEDICAMENTO --}}
                                    <div x-data="{ 
                                            query: '', 
                                            results: [], 
                                            open: false,
                                            loading: false,
                                            fetchResults() {
                                                if (this.query.length < 3) { this.results = []; this.open = false; return; }
                                                this.loading = true;
                                                fetch(`{{ route('medico.api.medicamentos.search') }}?q=${this.query}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        this.results = Array.isArray(data) ? data : [];
                                                        this.open = true; this.loading = false;
                                                    }).catch(() => { this.loading = false; this.open = false; });
                                            }
                                        }" @click.away="open = false" class="relative">
                                        <x-input-label for="medicamentos[0][nome_medicamento]" :value="__('Nome do Medicamento (pesquise)')" />
                                        <x-text-input name="medicamentos[0][nome_medicamento]" class="block mt-1 w-full" type="text" required x-model="query" @input.debounce.500ms="fetchResults()" autocomplete="off" />
                                        <span x-show="loading" class="text-sm text-gray-500">Buscando...</span>
                                        <div x-show="open" x-transition class="absolute z-10 w-full bg-white dark:bg-gray-800 border rounded-md shadow-lg mt-1 max-h-60 overflow-y-auto">
                                            <template x-for="result in results" :key="result.id">
                                                <div @click="query = result.nomeProduto; open = false;" class="p-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                                    <span class="font-bold" x-text="result.nomeProduto"></span>
                                                    <span class="text-sm text-gray-600 dark:text-gray-400 block" x-text="result.empresa"></span>
                                                </div>
                                            </template>
                                            <div x-show="!loading && results.length === 0 && query.length > 2" class="p-3 text-sm text-gray-500">Nenhum resultado encontrado.</div>
                                        </div>
                                    </div>
                                    {{-- FIM DO CAMPO DE BUSCA --}}

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="medicamentos[0][dosagem]" :value="__('Dosagem (ex: 500mg)')" />
                                            <x-text-input name="medicamentos[0][dosagem]" class="block mt-1 w-full" type="text" required />
                                        </div>
                                        <div>
                                            <x-input-label for="medicamentos[0][quantidade]" :value="__('Quantidade (ex: 1 caixa)')" />
                                            <x-text-input name="medicamentos[0][quantidade]" class="block mt-1 w-full" type="text" required />
                                        </div>
                                    </div>
                                    <div>
                                        <x-input-label for="medicamentos[0][posologia]" :value="__('Posologia (Instruções de uso)')" />
                                        <textarea name="medicamentos[0][posologia]" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="3" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <x-primary-button>
                                    {{ __('Gerar Prescrição') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const addButton = document.getElementById('add-medicamento-btn');
        const container = document.getElementById('medicamentos-container');
        const template = container.querySelector('.medicamento-item').cloneNode(true);
        let medicamentoIndex = 1;

        addButton.addEventListener('click', () => {
            const newItem = template.cloneNode(true);
            
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerHTML = 'Remover';
            removeButton.className = 'mt-2 px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700';
            newItem.appendChild(removeButton);

            newItem.querySelectorAll('[name]').forEach(element => {
                const name = element.getAttribute('name');
                if (name) {
                    element.setAttribute('name', name.replace(/\[0\]/, `[${medicamentoIndex}]`));
                    // Limpa os valores dos campos clonados
                    if (element.tagName === 'TEXTAREA') {
                        element.value = '';
                    } else if (element.type !== 'hidden') {
                        element.value = '';
                    }
                }
            });
            
            container.appendChild(newItem);
            // Inicializa o Alpine.js no novo elemento
            window.Alpine.initTree(newItem);
            medicamentoIndex++;
        });

        container.addEventListener('click', function(e) {
            if (e.target && e.target.tagName == 'BUTTON' && e.target.innerHTML === 'Remover') {
                e.target.closest('.medicamento-item').remove();
            }
        });
    });
    </script>
    