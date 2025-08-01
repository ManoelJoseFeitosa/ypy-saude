<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nome Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <hr class="my-6 border-gray-300 dark:border-gray-700">

        <div class="mt-4">
            <x-input-label for="tipo" :value="__('Eu sou...')" />
            <select name="tipo" id="tipo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                <option value="paciente" @selected(old('tipo', 'paciente') == 'paciente')>Paciente</option>
                <option value="medico" @selected(old('tipo') == 'medico')>Médico</option>
            </select>
        </div>

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
        </div>

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
        
        // Run on page load to set the initial state
        toggleFields(); 
    });
</script>