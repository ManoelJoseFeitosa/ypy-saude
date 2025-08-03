{{-- Em resources/views/welcome.blade.php --}}
<x-layouts.public>
    <section class="bg-white dark:bg-gray-800">
        <div class="container mx-auto px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-piaui-blue mb-4">Ypy Saúde: A Telemedicina do Piauí ao seu alcance.</h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Uma plataforma moderna e segura para emissão de prescrições médicas digitais. Médicos podem gerar receitas com validação e QR Code, e pacientes podem acessá-las de qualquer lugar, a qualquer hora. Simplificando a saúde com tecnologia.
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" class="px-8 py-3 bg-piaui-green text-white font-bold rounded-lg hover:bg-opacity-90 text-lg">Comece a Usar Agora</a>
            </div>
        </div>
    </section>
</x-layouts.public>