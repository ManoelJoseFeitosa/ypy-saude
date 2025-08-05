<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Agendar com Dr(a). {{ $medico->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('agendamento.store', $medico) }}">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-medium">1. Escolha uma data</h3>
                                <x-text-input id="date-picker" name="data" type="date" class="mt-2 block w-full md:w-1/2" />
                                <x-input-error :messages="$errors->get('data')" class="mt-2" />
                            </div>

                            <div id="horarios-container" class="hidden">
                                <h3 class="text-lg font-medium">2. Escolha um horário</h3>
                                <div id="horarios-disponiveis" class="mt-2 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                    <!-- Horários serão inseridos aqui pelo JavaScript -->
                                </div>
                                <div id="loading-spinner" class="hidden mt-4 text-center">Carregando horários...</div>
                                <div id="no-horarios-msg" class="hidden mt-4 text-gray-500">Nenhum horário disponível para esta data.</div>
                                <x-input-error :messages="$errors->get('horario')" class="mt-2" />
                            </div>

                            <div id="notas-container" class="hidden">
                                <h3 class="text-lg font-medium">3. Informações Adicionais (Opcional)</h3>
                                <textarea name="notas_paciente" rows="3" class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Deseja informar o motivo da consulta?"></textarea>
                            </div>

                            <div id="submit-button-container" class="hidden">
                                <x-primary-button>Confirmar Agendamento</x-primary-button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const datePicker = document.getElementById('date-picker');
            const horariosContainer = document.getElementById('horarios-container');
            const horariosDisponiveisDiv = document.getElementById('horarios-disponiveis');
            const loadingSpinner = document.getElementById('loading-spinner');
            const noHorariosMsg = document.getElementById('no-horarios-msg');
            const notasContainer = document.getElementById('notas-container');
            const submitButtonContainer = document.getElementById('submit-button-container');

            // Define a data mínima como hoje
            datePicker.min = new Date().toISOString().split("T")[0];

            datePicker.addEventListener('change', function () {
                const selectedDate = this.value;
                if (!selectedDate) return;

                // Mostra o spinner e esconde mensagens antigas
                horariosContainer.classList.remove('hidden');
                horariosDisponiveisDiv.innerHTML = '';
                loadingSpinner.classList.remove('hidden');
                noHorariosMsg.classList.add('hidden');
                notasContainer.classList.add('hidden');
                submitButtonContainer.classList.add('hidden');

                const url = `/agendamento/medico/{{ $medico->id }}/horarios?date=${selectedDate}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        loadingSpinner.classList.add('hidden');
                        
                        if (data.horarios && data.horarios.length > 0) {
                            data.horarios.forEach(horario => {
                                const radioLabel = document.createElement('label');
                                radioLabel.className = 'block';

                                const radioInput = document.createElement('input');
                                radioInput.type = 'radio';
                                radioInput.name = 'horario';
                                radioInput.value = horario;
                                radioInput.className = 'hidden peer';
                                radioInput.required = true;

                                const radioSpan = document.createElement('span');
                                radioSpan.textContent = horario;
                                radioSpan.className = 'block w-full text-center p-2 border rounded-md cursor-pointer peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 dark:border-gray-600 dark:peer-checked:bg-indigo-500';

                                radioLabel.appendChild(radioInput);
                                radioLabel.appendChild(radioSpan);
                                horariosDisponiveisDiv.appendChild(radioLabel);

                                radioInput.addEventListener('change', () => {
                                    notasContainer.classList.remove('hidden');
                                    submitButtonContainer.classList.remove('hidden');
                                });
                            });
                        } else {
                            noHorariosMsg.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar horários:', error);
                        loadingSpinner.classList.add('hidden');
                        noHorariosMsg.textContent = 'Ocorreu um erro ao carregar os horários. Tente novamente.';
                        noHorariosMsg.classList.remove('hidden');
                    });
            });
        });
    </script>
    @endpush
</x-app-layout>
