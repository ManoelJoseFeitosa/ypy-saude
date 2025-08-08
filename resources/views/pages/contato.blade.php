{{-- Em resources/views/pages/contato.blade.php --}}
<x-layouts.public>
    <x-slot:title>Contato - Ypy Saúde</x-slot:title>

    <div class="bg-white dark:bg-gray-800 py-12">
        <div class="container mx-auto px-6">
            <div class="text-center">
                <h2 class="text-3xl font-bold text-piaui-blue mb-4">Entre em Contato</h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Tem alguma dúvida, sugestão ou precisa de suporte? Preencha o formulário abaixo ou utilize um de nossos canais de atendimento.
                </p>
            </div>

            <div class="mt-12 max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="text-gray-700 dark:text-gray-300">
                    <h3 class="text-xl font-bold mb-4 text-piaui-blue">Nossos Canais</h3>
                    <p class="mb-2"><strong>Email:</strong> contato@ypysaude.com.br</p>
                    <h3 class="text-xl font-bold mt-8 mb-4 text-piaui-blue">Contate-nos:</h3>
                    <p>Nos envie uma mensagem e saiba mais.</p>
                </div>

                <form action="#" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seu Nome</label>
                            <input type="text" name="name" id="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Seu Email</label>
                            <input type="email" name="email" id="email" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sua Mensagem</label>
                            <textarea name="message" id="message" rows="5" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-900 dark:border-gray-700"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-6 py-3 bg-piaui-blue text-white font-bold rounded-lg hover:bg-opacity-90">
                                Enviar Mensagem
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.public>