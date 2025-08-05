<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Gestão de Horários de Atendimento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Formulário para Adicionar Novo Horário --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Adicionar Novo Horário</h3>
                    <form method="POST" action="{{ route('medico.horarios.store') }}" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="dia_semana" value="Dia da Semana" />
                            <select id="dia_semana" name="dia_semana" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                @foreach($diasSemana as $numero => $nome)
                                    <option value="{{ $numero }}">{{ $nome }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('dia_semana')" />
                        </div>

                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <x-input-label for="hora_inicio" value="Hora de Início" />
                                <x-text-input id="hora_inicio" name="hora_inicio" type="time" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('hora_inicio')" />
                            </div>
                            <div class="flex-1">
                                <x-input-label for="hora_fim" value="Hora de Fim" />
                                <x-text-input id="hora_fim" name="hora_fim" type="time" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('hora_fim')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="duracao_consulta" value="Duração da Consulta (minutos)" />
                            <x-text-input id="duracao_consulta" name="duracao_consulta" type="number" class="mt-1 block w-full" value="30" />
                            <x-input-error class="mt-2" :messages="$errors->get('duracao_consulta')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>Adicionar Horário</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Lista de Horários Atuais --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Meus Horários</h3>
                <div class="mt-6 space-y-4">
                    @forelse ($horarios->groupBy('dia_semana') as $dia => $horariosDoDia)
                        <div class="border-t pt-4">
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ $diasSemana[$dia] }}</h4>
                            <ul class="mt-2 space-y-2">
                                @foreach($horariosDoDia as $horario)
                                    <li class="flex items-center justify-between p-2 bg-gray-50 dark:bg-gray-700/50 rounded-md">
                                        <span class="text-gray-900 dark:text-gray-100">
                                            Das <strong>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</strong> às <strong>{{ \Carbon\Carbon::parse($horario->hora_fim)->format('H:i') }}</strong>
                                            (consultas de {{ $horario->duracao_consulta }} min)
                                        </span>
                                        <form method="POST" action="{{ route('medico.horarios.destroy', $horario) }}">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit">Remover</x-danger-button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400">Ainda não adicionou nenhum horário de atendimento.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
