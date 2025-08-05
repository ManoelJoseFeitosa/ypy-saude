<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Agendar Consulta - Escolha um Profissional
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($medicos as $medico)
                            <div class="p-4 border dark:border-gray-700 rounded-lg">
                                <h3 class="font-bold text-lg">{{ $medico->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $medico->medicoProfile->especialidade ?? 'Clínico Geral' }}
                                </p>
                                <a href="{{ route('agendamento.show', $medico) }}" class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">
                                    Ver Agenda &rarr;
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
