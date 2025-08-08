<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Novo Atestado Médico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('medico.atestados.store') }}">
                        @csrf

                        {{-- Seletor de Paciente --}}
                        <div class="mb-6">
                            <x-input-label for="paciente_id" :value="__('Selecione o Paciente')" />
                            <select name="paciente_id" id="paciente_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                <option value="">-- Selecione um paciente --</option>
                                @foreach ($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            {{-- Dias de Afastamento --}}
                            <div>
                                <x-input-label for="dias_afastamento" :value="__('Dias de Afastamento')" />
                                <x-text-input id="dias_afastamento" class="block mt-1 w-full" type="number" name="dias_afastamento" :value="old('dias_afastamento')" required min="1" />
                            </div>

                            {{-- CAMPO DE CID SIMPLIFICADO --}}
                            <div>
                                <x-input-label for="cid" :value="__('CID (Código Internacional de Doenças)')" />
                                <x-text-input id="cid" class="block mt-1 w-full" type="text" name="cid" :value="old('cid')" required />
                            </div>
                        </div>

                        {{-- Motivo --}}
                        <div class="mb-6">
                            <x-input-label for="motivo" :value="__('Motivo / Observações')" />
                            <textarea name="motivo" id="motivo" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>{{ old('motivo') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <x-primary-button>
                                {{ __('Gerar Atestado') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
