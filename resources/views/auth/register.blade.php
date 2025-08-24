<x-guest-layout>
    {{-- Container principal que centraliza o card do formulário --}}
    <div class="min-h-[80vh] flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
        <div class="w-full max-w-lg bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 my-8">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-blue-900 dark:text-white">Crie sua Conta</h2>
                <p class="text-gray-600 dark:text-gray-300">Junte-se à Ypy Saúde e modernize seus atendimentos.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nome Completo -->
                <div>
                    <x-input-label for="name" value="Nome Completo" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Senha -->
                <div class="mt-4">
                    <x-input-label for="password" value="Senha" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar Senha -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" value="Confirmar Senha" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <hr class="my-6 border-gray-200 dark:border-gray-700">

                <!-- Seletor de Tipo de Usuário -->
                <div class="mt-4">
                    <x-input-label for="tipo" value="Eu sou..." />
                    <select name="tipo" id="tipo" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm">
                        <option value="paciente" @selected(old('tipo', 'paciente') == 'paciente')>Paciente</option>
                        <option value="medico" @selected(old('tipo') == 'medico')>Médico</option>
                    </select>
                </div>

                <!-- Campos Condicionais de Médico -->
                <div id="medico_fields" class="space-y-4 mt-4" style="display: none;">
                    <div>
                        <x-input-label for="crm" value="CRM" />
                        <x-text-input id="crm" class="block mt-1 w-full" type="text" name="crm" :value="old('crm')" />
                        <x-input-error :messages="$errors->get('crm')" class="mt-2" />
                    </div>
                     <div>
                        <x-input-label for="uf_crm" value="UF do CRM (ex: PI)" />
                        <x-text-input id="uf_crm" class="block mt-1 w-full" type="text" name="uf_crm" :value="old('uf_crm')" maxlength="2" />
                        <x-input-error :messages="$errors->get('uf_crm')" class="mt-2" />
                    </div>
                </div>

                <!-- Campos Condicionais de Paciente -->
                <div id="paciente_fields" class="space-y-4 mt-4" style="display: none;">
                    <div>
                        <x-input-label for="cpf" value="CPF (apenas números)" />
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

                <!-- Checkbox de Termos de Uso -->
                <div class="mt-6">
                    <label for="terms" class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Eu li e aceito os <a href="#" target="_blank" class="underline hover:text-blue-600">Termos de Uso</a>.</span>
                    </label>
                    <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                        Já é registrado?
                    </a>

                    <x-primary-button class="ml-4 bg-green-500 hover:bg-green-600">
                        Registrar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

<script>
    // Script para alternar a visibilidade dos campos de acordo com o tipo de usuário
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const medicoFields = document.getElementById('medico_fields');
        const pacienteFields = document.getElementById('paciente_fields');

        const toggleFields = () => {
            if (tipoSelect.value === 'medico') {
                medicoFields.style.display = 'block';
                pacienteFields.style.display = 'none';
            } else { // 'paciente'
                medicoFields.style.display = 'none';
                pacienteFields.style.display = 'block';
            }
        };

        tipoSelect.addEventListener('change', toggleFields);
        
        // Executa ao carregar a página para definir o estado inicial correto
        toggleFields(); 
    });
</script>
