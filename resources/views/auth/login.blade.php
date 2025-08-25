<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-6 py-12 lg:py-20">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
            
            <div class="text-center mb-8">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo_ypysaude.png') }}" alt="Logo Ypy Saúde" class="w-24 mx-auto mb-4">
                </a>
                <h2 class="text-2xl font-bold text-blue-900 dark:text-white">Acesse sua Conta</h2>
                <p class="text-gray-600 dark:text-gray-300">Bem-vindo de volta!</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" value="Senha" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Lembrar-me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <div>
                    <x-primary-button class="w-full justify-center py-3 bg-green-500 hover:bg-green-600">
                        Entrar na Plataforma
                    </x-primary-button>
                </div>
                 <div class="text-center">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                        Não tem uma conta? Cadastre-se
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
