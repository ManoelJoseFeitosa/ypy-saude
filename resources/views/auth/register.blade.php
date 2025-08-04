<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nome Completo --}}
        <div>
            <x-input-label for="name" :value="__('Nome Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Senha --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Confirmar Senha --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <hr class="my-6 border-gray-300 dark:border-gray-700">

        <!-- Seletor de Tipo de Usuário -->
        <div class="mt-4">
            <x-input-label for="tipo" :value="__('Eu sou...')" />
            <select name="tipo" id="tipo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 rounded-md shadow-sm">
                <option value="paciente" @selected(old('tipo', 'paciente') == 'paciente')>Paciente</option>
                <option value="medico" @selected(old('tipo') == 'medico')>Médico</option>
            </select>
        </div>

        {{-- Campos Condicionais de Médico --}}
        <div id="medico_fields" class="space-y-4 mt-4" style="display: none;">
            <div>
                <x-input-label for="crm" :value="__('CRM')" />
                <x-text-input id="crm" class="block mt-1 w-full" type="text" name="crm" :value="old('crm')" />
                <x-input-error :messages="$errors->get('crm')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="uf_crm" :value="__('UF do CRM (ex: PI)')" />
                <x-text-input id="uf_crm" class="block mt-1 w-full" type="text" name="uf_crm" :value="old('uf_crm')" maxlength="2" />
                <x-input-error :messages="$errors->get('uf_crm')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="especialidade" :value="__('Especialidade (Opcional)')" />
                <x-text-input id="especialidade" class="block mt-1 w-full" type="text" name="especialidade" :value="old('especialidade')" />
            </div>
            <div>
                <x-input-label for="rqe" :value="__('RQE (Opcional)')" />
                <x-text-input id="rqe" class="block mt-1 w-full" type="text" name="rqe" :value="old('rqe')" />
            </div>
            <div>
                <x-input-label for="endereco_completo" :value="__('Endereço Profissional Completo')" />
                <x-text-input id="endereco_completo" class="block mt-1 w-full" type="text" name="endereco_completo" :value="old('endereco_completo')" />
            </div>
        </div>

        {{-- Campos Condicionais de Paciente --}}
        <div id="paciente_fields" class="space-y-4 mt-4" style="display: none;">
            <div>
                <x-input-label for="cpf" :value="__('CPF (apenas números)')" />
                <x-text-input 
                    id="cpf" 
                    class="block mt-1 w-full" 
                    type="text" 
                    name="cpf" 
                    :value="old('cpf')" 
                    x-data 
                    x-mask="999.999.999-99" 
                    placeholder="000.000.000-00" />
                <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
            </div>

            {{-- CAMPO DE BUSCA DE MÉDICO ADICIONADO --}}
            <div x-data="{ 
                    query: '', 
                    results: [], 
                    open: false, 
                    loading: false,
                    fetchResults() {
                        if (this.query.length < 3) { this.results = []; this.open = false; return; }
                        this.loading = true;
                        fetch(`{{ route('api.medicos.search') }}?q=${this.query}`)
                            .then(response => response.json())
                            .then(data => {
                                this.results = data; this.open = true; this.loading = false;
                            });
                    }
                }" @click.away="open = false" class="relative">
                <x-input-label for="medico_search" :value="__('Vincular a um médico (opcional)')" />
                <input type="hidden" name="medico_id" x-ref="medico_id">
                <x-text-input 
                    id="medico_search" 
                    class="block mt-1 w-full" 
                    type="text" 
                    x-model="query" 
                    @input.debounce.500ms="fetchResults()"
                    placeholder="Digite o nome do médico"
                    autocomplete="off"
                />
                <span x-show="loading" class="text-sm text-gray-500">Buscando...</span>

                <div x-show="open" x-transition class="absolute z-10 w-full bg-white dark:bg-gray-800 border rounded-md shadow-lg mt-1 max-h-60 overflow-y-auto">
                    <template x-for="result in results" :key="result.id">
                        <div @click="query = result.name; $refs.medico_id.value = result.id; open = false;" class="p-3 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                            <span class="font-bold" x-text="result.name"></span>
                            <span class="text-sm text-gray-600 dark:text-gray-400 block" x-text="'CRM: ' + result.medico_profile.crm + '/' + result.medico_profile.uf_crm"></span>
                        </div>
                    </template>
                    <div x-show="!loading && results.length === 0 && query.length > 2" class="p-3 text-sm text-gray-500">Nenhum médico encontrado.</div>
                </div>
            </div>
        </div>

        {{-- Checkbox de Termos de Uso --}}
        <div class="mt-4">
            <div class="flex items-center">
                <x-checkbox name="terms" id="terms" required />
                <label for="terms" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    Eu li e aceito os <a href="{{ route('termos') }}" target="_blank" class="underline hover:text-gray-900">Termos de Uso e Política de Privacidade</a>.
                </label>
            </div>
            <x-input-error :messages="$errors->get('terms')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Já é registrado?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const medicoFields = document.getElementById('medico_fields');
        const pacienteFields = document.getElementById('paciente_fields');

        const toggleFields = () => {
            if (tipoSelect.value === 'medico') {
                medicoFields.style.display = 'block';
                pacienteFields.style.display = 'none';
            } else if (tipoSelect.value === 'paciente') {
                medicoFields.style.display = 'none';
                pacienteFields.style.display = 'block';
            }
        };

        tipoSelect.addEventListener('change', toggleFields);
        
        // Executa ao carregar a página para definir o estado inicial
        toggleFields(); 
    });
</script>
