<x-guest-layout>
    <div class="flex flex-wrap min-h-[85vh]">
        
        {{-- Coluna Esquerda: Branding (visível em telas médias ou maiores) --}}
        <div class="w-full md:w-1/2 hidden md:flex flex-col justify-center items-center bg-blue-800 p-12 text-white text-center">
            <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="w-32 mb-6">
            <h1 class="text-3xl font-bold text-yellow-300 mb-4">Bem-vindo de Volta!</h1>
            <p class="max-w-sm">
                Acesse sua conta para gerenciar prescrições, agendamentos e muito mais.
            </p>
        </div>

        {{-- Coluna Direita: Formulário --}}
        <div class="w-full md:w-1/2 flex flex-col justify-center items-center p-6 md:p-12 bg-gray-50">
            <div class="w-full max-w-sm">
                <div class="text-center md:text-left mb-8">
                    <h2 class="text-2xl font-bold text-blue-900">Acesse sua Conta</h2>
                    <p class="text-gray-600">Bem-vindo de volta!</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" value="Senha" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                            <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md" href="{{ route('password.request') }}">
                                Esqueceu sua senha?
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full justify-center py-3 bg-green-500 hover:bg-green-600">
                            Entrar na Plataforma
                        </x-primary-button>
                    </div>

                     <div class="mt-6 text-center">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                            Não tem uma conta? Cadastre-se
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
