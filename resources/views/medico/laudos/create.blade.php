    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Novo Laudo Médico') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                        
                        <form method="POST" action="{{ route('medico.laudos.store') }}">
                            @csrf

                            <!-- Seletor de Paciente -->
                            <div class="mb-6">
                                <x-input-label for="paciente_id" :value="__('Selecione o Paciente')" />
                                <select name="paciente_id" id="paciente_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>
                                    <option value="">-- Selecione um paciente --</option>
                                    @foreach ($pacientes as $paciente)
                                        <option value="{{ $paciente->id }}">{{ $paciente->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Título do Laudo -->
                            <div class="mb-6">
                                <x-input-label for="titulo" :value="__('Título do Laudo (ex: Laudo de Exame de Sangue)')" />
                                <x-text-input id="titulo" class="block mt-1 w-full" type="text" name="titulo" :value="old('titulo')" required />
                            </div>

                            <!-- Conteúdo do Laudo -->
                            <div class="mb-6">
                                <x-input-label for="conteudo" :value="__('Conteúdo do Laudo')" />
                                <textarea name="conteudo" id="conteudo" rows="15" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm" required>{{ old('conteudo') }}</textarea>
                            </div>

                            <div class="flex items-center justify-end mt-8">
                                <x-primary-button>
                                    {{ __('Gerar Laudo em PDF') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    