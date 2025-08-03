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

                            {{-- CAMPO DE BUSCA INTELIGENTE PARA O CID --}}
                            <div 
                                x-data="{ 
                                    query: '{{ old('cid', '') }}', 
                                    results: [], 
                                    open: false,
                                    loading: false,
                                    fetchResults() {
                                        if (this.query.length < 2) {
                                            this.results = [];
                                            this.open = false;
                                            return;
                                        }
                                        this.loading = true;
                                        fetch(`{{ route('medico.api.cid.search') }}?q=${this.query}`, {
                                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                        })
                                            .then(response => response.json())
                                            .then(data => {
                                                this.results = Array.isArray(data) ? data : [];
                                                this.open = true;
                                                this.loading = false;
                                            })
                                            .catch(() => {
                                                this.loading = false;
                                                this.open = false;
                                                this.results = [];
                                            });
                                    }
                                }" 
                                @click.away="open = false" 
                                class="relative"
                            >
                                <x-input-label for="cid" :value="__('CID (pesquise por código ou nome)')" />
                                <x-text-input 
                                    id="cid" 
                                    class="block mt-1 w-full" 
                                    type="text" 
                                    name="cid" 
                                    x-model="query" 
                                    @input.debounce.500ms="fetchResults()"
                                    @focus="if(results.length > 0) open = true"
                                    autocomplete="off"
                                />
                                <span x-show="loading" class="text-sm text-gray-500">Buscando...</span>

                                <div x-show="open" x-transition class="absolute z-10 w-full bg-white dark:bg-gray-800 border rounded-md shadow-lg mt-1 max-h-60 overflow-y-auto">
                                    <template x-for="result in results" :key="result.codigo">
                                        <div 
                                            @click="query = result.codigo; open = false;" 
                                            class="p-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer"
                                        >
                                            <span class="font-bold" x-text="result.codigo"></span>
                                            <span class="text-sm text-gray-600 dark:text-gray-400" x-text="'- ' + result.descricao"></span>
                                        </div>
                                    </template>
                                    <div x-show="!loading && results.length === 0 && query.length > 1" class="p-3 text-sm text-gray-500">
                                        Nenhum resultado encontrado.
                                    </div>
                                </div>
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
