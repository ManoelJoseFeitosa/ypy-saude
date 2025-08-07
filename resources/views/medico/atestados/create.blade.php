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
                        <div class="mb-6">
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

                        <!-- Seletor de Modelo de Receita -->
                        <div class="mb-6">
                            <x-input-label for="tipo" :value="__('Modelo de Receita')" />
                            <select name="tipo" id="tipo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                <option value="simples">Receita Simples</option>
                                <option value="especial">Controle Especial (2 vias)</option>
                                <option value="amarela">Receituário Amarelo (A)</option>
                                <option value="azul">Receituário Azul (B)</option>
                            </select>
                        </div>

                        <hr class="my-8 border-gray-300 dark:border-gray-700">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Medicamentos</h3>
                            <button type="button" id="add-medicamento-btn" class="px-3 py-1 bg-green-600 text-white rounded-md text-sm hover:bg-green-700" style="background-color: #00995D;">+ Adicionar</button>
                        </div>

                        <div id="medicamentos-container" class="space-y-6">
                            {{-- Bloco de Medicamento 1 (template) --}}
                            <div class="medicamento-item p-4 border border-gray-200 dark:border-gray-700 rounded-lg space-y-4">
                                
                                {{-- CAMPO DE NOME DO MEDICAMENTO SIMPLIFICADO --}}
                                <div>
                                    <x-input-label for="medicamentos[0][nome_medicamento]" :value="__('Nome do Medicamento')" />
                                    <x-text-input name="medicamentos[0][nome_medicamento]" class="block mt-1 w-full" type="text" required />
                                </div>

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
// O script para adicionar e remover medicamentos continua o mesmo,
// mas sem a necessidade de inicializar o Alpine.js.
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
        removeButton.className = 'mt-2 px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700 self-end';
        newItem.insertBefore(removeButton, newItem.firstChild);

        newItem.querySelectorAll('[name]').forEach(element => {
            const name = element.getAttribute('name');
            if (name) {
                element.setAttribute('name', name.replace(/\[0\]/, `[${medicamentoIndex}]`));
                if (element.tagName === 'TEXTAREA') {
                    element.value = '';
                } else if (element.type !== 'hidden') {
                    element.value = '';
                }
            }
        });
        
        container.appendChild(newItem);
        medicamentoIndex++;
    });

    container.addEventListener('click', function(e) {
        if (e.target && e.target.tagName == 'BUTTON' && e.target.innerHTML === 'Remover') {
            e.target.closest('.medicamento-item').remove();
        }
    });
});
</script>
