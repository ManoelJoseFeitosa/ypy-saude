{{-- Em resources/views/medico/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-piaui-blue dark:text-gray-200 leading-tight">
        {{ __('Painel do Médico') }}
        </h2>
    </x-slot>

    {{-- Seção para exibir a mensagem de sucesso --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        @if (session('success'))
            <div class="p-4 mb-4 bg-green-100 border border-green-400 text-green-800 rounded-md" style="background-color: #d1f2e5; color: #006b43; border-color: #00995d;">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Card de Boas-Vindas e Botão de Ação --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Bem-vindo(a), Dr(a). {{ Auth::user()->name }}!</h3>
                    <p class="mt-2">A partir deste painel você pode gerenciar seus pacientes e emitir novas prescrições.</p>
                    
                    <div class="mt-6">
                        <a href="{{ route('medico.prescricoes.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest transition ease-in-out duration-150" style="background-color: #002e7a; hover:background-color: #001f54;">
                            + Nova Prescrição
                        </a>
                    </div>
                </div>
            </div>

            {{-- Card do Histórico de Prescrições --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Histórico de Prescrições</h3>

                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Data</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Paciente</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Ações</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($prescricoes as $prescricao)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $prescricao->paciente->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm capitalize">{{ $prescricao->status }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            {{-- LINK CORRIGIDO ABAIXO --}}
                                            <a href="{{ route('medico.prescricoes.show', $prescricao) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">Visualizar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">
                                            Nenhuma prescrição emitida ainda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Links de Paginação --}}
                    <div class="mt-4">
                        {{ $prescricoes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>