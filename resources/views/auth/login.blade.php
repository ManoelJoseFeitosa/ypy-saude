<x-guest-layout>
    <div class="min-h-[60vh] flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">
            
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-blue-900 dark:text-white">Bem-vindo de volta!</h2>
                <p class="text-gray-600 dark:text-gray-300">Acesse sua conta para continuar.</p>
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
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Lembrar-me</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            Esqueceu sua senha?
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-green-500 hover:bg-green-600">
                        Entrar
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
