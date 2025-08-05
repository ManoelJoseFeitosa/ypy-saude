{{-- Este layout deve ser o layout principal da área logada do seu paciente --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detalhes do Documento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-2xl font-bold mb-4">
                        {{ ucfirst($tipo) }} emitido por Dr(a). {{ $documento->medico->name }}
                    </h3>

                    <p class="mb-2"><strong>Data de Emissão:</strong> {{ \Carbon\Carbon::parse($documento->created_at)->format('d/m/Y') }}</p>
                    <p class="mb-6"><strong>Paciente:</strong> {{ $documento->paciente->name }}</p>

                    {{-- Detalhes da Prescrição --}}
                    @if($tipo === 'prescrição' && $documento->medicamentos)
                        <div class="mt-6 border-t pt-4">
                            <h4 class="text-xl font-semibold mb-3">Medicamentos Prescritos</h4>
                            <ul class="list-disc list-inside space-y-4">
                                @foreach($documento->medicamentos as $medicamento)
                                    <li>
                                        <strong>{{ $medicamento->nome_medicamento }}</strong> ({{ $medicamento->dosagem }})
                                        <p class="text-sm text-gray-600 dark:text-gray-400 ml-6">
                                            - Quantidade: {{ $medicamento->quantidade }} <br>
                                            - Posologia: {{ $medicamento->posologia }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Detalhes do Atestado --}}
                    @if($tipo === 'atestado')
                        <div class="mt-6 border-t pt-4 space-y-3">
                            <h4 class="text-xl font-semibold mb-3">Detalhes do Atestado</h4>
                            <p><strong>CID:</strong> {{ $documento->cid ?? 'Não informado' }}</p>
                            <p><strong>Dias de Afastamento:</strong> {{ $documento->dias_afastamento ?? 'Não especificado' }}</p>
                            <div>
                                <p><strong>Observações:</strong></p>
                                <p class="pl-2 mt-1">{{ $documento->observacoes }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Detalhes do Laudo --}}
                    @if($tipo === 'laudo')
                        <div class="mt-6 border-t pt-4">
                             <h4 class="text-xl font-semibold mb-3">Descrição do Laudo</h4>
                             <p>{{ $documento->descricao }}</p>
                        </div>
                    @endif


                    <div class="mt-8 border-t pt-6">
                        @php
                            // Define a rota correta para o PDF com base no tipo
                            $pdfRoute = '';
                            if ($tipo === 'prescrição') $pdfRoute = route('medico.prescricoes.pdf', $documento->id);
                            if ($tipo === 'atestado') $pdfRoute = route('medico.atestados.pdf', $documento->id);
                            if ($tipo === 'laudo') $pdfRoute = route('medico.laudos.pdf', $documento->id);
                        @endphp

                        <a href="{{ $pdfRoute }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Baixar PDF
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
