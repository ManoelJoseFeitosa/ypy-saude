<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-6 py-12 lg:py-16">
        <div class="w-full max-w-lg bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
            
            <div class="text-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="w-24 mx-auto mb-4">
                </a>
                <h2 class="text-2xl font-bold text-blue-900 dark:text-white">Crie sua Conta</h2>
                <p class="text-gray-600 dark:text-gray-300">Cadastro rápido para médicos e pacientes.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="name" value="Nome Completo" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="password" value="Senha" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="password_confirmation" value="Confirmar Senha" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>
                </div>

                <hr class="!my-6 border-gray-200 dark:border-gray-700">

                <div>
                    <x-input-label for="tipo" value="Eu sou..." />
                    <select name="tipo" id="tipo" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                        <option value="paciente" @selected(old('tipo', 'paciente') == 'paciente')>Paciente</option>
                        <option value="medico" @selected(old('tipo') == 'medico')>Médico</option>
                    </select>
                </div>

                <div id="medico_fields" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="crm" value="CRM" />
                            <x-text-input id="crm" class="block mt-1 w-full" type="text" name="crm" :value="old('crm')" />
                            <x-input-error :messages="$errors->get('crm')" class="mt-2" />
                        </div>
                         <div>
                            <x-input-label for="uf_crm" value="UF do CRM" />
                            <x-text-input id="uf_crm" class="block mt-1 w-full" type="text" name="uf_crm" :value="old('uf_crm')" maxlength="2" placeholder="PI" />
                            <x-input-error :messages="$errors->get('uf_crm')" class="mt-2" />
                        </div>
                    </div>
                </div>
                <div id="paciente_fields" style="display: none;">
                    <div>
                        <x-input-label for="cpf" value="CPF" />
                        <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" x-data x-mask="999.999.999-99" placeholder="000.000.000-00" />
                        <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                    </div>
                </div>

                <div class="!mt-6">
                    <label for="terms" class="flex items-center">
                        <x-checkbox name="terms" id="terms" required />
                        <span class="ml-2 text-sm text-gray-600">Eu li e aceito os <a href="#" target="_blank" class="underline hover:text-blue-600">Termos de Uso</a>.</span>
                    </label>
                </div>

                <div class="!mt-6 flex items-center justify-between">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        Já tem uma conta?
                    </a>
                    <x-primary-button class="bg-green-500 hover:bg-green-600">
                        Finalizar Cadastro
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
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
            } else {
                medicoFields.style.display = 'none';
                pacienteFields.style.display = 'block';
            }
        };
        tipoSelect.addEventListener('change', toggleFields);
        toggleFields(); 
    });
</script>
