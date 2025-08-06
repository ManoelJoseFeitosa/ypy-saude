<x-guest-layout>
    {{-- TEXTO DE INSTRUÇÃO TRADUZIDO --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-200">
        {{ __('Esqueceu sua senha? Sem problemas. Apenas nos informe seu endereço de e-mail e enviaremos um link para redefinir sua senha, que permitirá que você escolha uma nova.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{-- TEXTO DO BOTÃO TRADUZIDO --}}
                {{ __('Enviar Link de Redefinição de Senha') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>