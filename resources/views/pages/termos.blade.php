<x-layouts.public>
    {{-- Define o título da página --}}
    <x-slot:title>Termos de Uso e Política de Privacidade - Ypy Saúde</x-slot:title>

    {{-- Conteúdo principal da página --}}
    <div class="bg-white dark:bg-gray-800 py-12">
        <div class="container mx-auto px-6 text-justify">

            {{-- O uso da classe "prose" do Tailwind ajuda a estilizar o conteúdo de texto --}}
            {{-- As classes text-lg e text-justify aplicam o tamanho de fonte maior e o alinhamento justificado --}}
            <article class="prose lg:prose-lg dark:prose-invert max-w-none text-lg">

                <h1 class="text-3xl font-bold mb-4">Termos de Uso e Política de Privacidade – Ypy Saúde</h1>
                <p class="text-base text-gray-600 dark:text-gray-400 mb-6"><strong>Última atualização:</strong> 04 de Agosto de 2025</p>
                <p class="mb-6">Bem-vindo(a) ao Ypy Saúde. Ao se cadastrar e utilizar nossa plataforma, você concorda com os seguintes termos e condições, que visam garantir a segurança, a ética e a conformidade legal na prestação de serviços de saúde digital, em acordo com a Lei Geral de Proteção de Dados (LGPD, Lei nº 13.709/2018) e a Resolução CFM nº 2.299/2021.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">1. Sobre a Plataforma</h2>
                <p class="mb-6">O Ypy Saúde é uma plataforma tecnológica que facilita a emissão e o gerenciamento de documentos médicos eletrônicos (prescrições, atestados, laudos) entre médicos e pacientes, visando otimizar o atendimento em saúde.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">2. Cadastro e Responsabilidades do Usuário</h2>
                <p class="mb-4"><strong>Usuário Paciente:</strong> Ao se cadastrar, você declara que as informações fornecidas (nome, e-mail, CPF) são verdadeiras e corretas. Você é responsável por manter a confidencialidade de sua senha e por todas as atividades que ocorrerem em sua conta.</p>
                <p class="mb-6"><strong>Usuário Médico:</strong> Ao se cadastrar, você declara ser um médico com registro ativo e regular no Conselho Regional de Medicina (CRM) da sua jurisdição. Você é o único responsável pela veracidade e legalidade das informações profissionais fornecidas (nome, CRM, RQE, endereço) e pela emissão dos documentos médicos, que são atos médicos de sua exclusiva competência e responsabilidade.</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">3. Emissão de Documentos Médicos Eletrônicos</h2>
                <ul class="list-disc list-inside space-y-3 mb-6">
                    <li>Conforme a Resolução CFM nº 2.299/2021, todos os documentos emitidos na plataforma devem conter a identificação completa do médico e do paciente, data, hora e assinatura digital do médico (padrão ICP-Brasil).</li>
                    <li>O Ypy Saúde oferece a ferramenta para a geração do documento, mas a responsabilidade pelo conteúdo, diagnóstico e tratamento prescrito é integralmente do médico emissor.</li>
                    <li>É vedado ao médico direcionar prescrições a estabelecimentos farmacêuticos específicos através da plataforma.</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">4. Política de Privacidade e Proteção de Dados (LGPD)</h2>
                <p class="mb-4">O Ypy Saúde está comprometido com a proteção dos seus dados pessoais e de saúde, que são classificados como dados sensíveis.</p>
                <h3 class="text-xl font-bold mt-6 mb-3">Coleta de Dados</h3>
                <p class="mb-4">Coletamos os dados estritamente necessários para o funcionamento da plataforma:</p>
                <ul class="list-disc list-inside space-y-3 mb-4 ml-4">
                    <li><strong>Pacientes:</strong> Nome, e-mail, CPF.</li>
                    <li><strong>Médicos:</strong> Nome, e-mail, CRM, UF do CRM, RQE, endereço profissional.</li>
                    <li><strong>Dados de Saúde:</strong> As informações contidas nos documentos médicos emitidos (prescrições, atestados, laudos, prontuários) são processadas pela plataforma, mas permanecem sob a guarda e responsabilidade do médico emissor.</li>
                </ul>
                <h3 class="text-xl font-bold mt-6 mb-3">Finalidade do Uso</h3>
                <p class="mb-4">Seus dados são utilizados exclusivamente para:</p>
                 <ul class="list-disc list-inside space-y-3 mb-4 ml-4">
                    <li>Viabilizar a criação e o acesso aos documentos médicos.</li>
                    <li>Garantir a identificação correta de médicos e pacientes.</li>
                    <li>Permitir a validação de autenticidade dos documentos gerados.</li>
                </ul>
                <h3 class="text-xl font-bold mt-6 mb-3">Compartilhamento</h3>
                <p class="mb-4">Seus dados de saúde não serão compartilhados com terceiros sem o seu consentimento explícito, exceto quando exigido por lei ou para a validação de documentos junto a farmácias e outros serviços de saúde, sempre de forma segura.</p>
                <h3 class="text-xl font-bold mt-6 mb-3">Segurança</h3>
                <p class="mb-4">Utilizamos medidas de segurança técnicas e administrativas para proteger seus dados, como criptografia, controle de acesso e monitoramento constante, visando prevenir acessos não autorizados e situações de perda ou vazamento de dados.</p>
                <h3 class="text-xl font-bold mt-6 mb-3">Seus Direitos</h3>
                <p class="mb-6">Como titular dos dados, você tem o direito de solicitar o acesso, a correção, a anonimização ou a eliminação de seus dados pessoais, nos limites previstos pela LGPD (Lei Geral de Proteção de Dados).</p>

                <h2 class="text-2xl font-bold mt-8 mb-4">5. Aceite dos Termos</h2>
                <p class="mb-4">Ao marcar a caixa "Li e aceito os Termos de Uso e a Política de Privacidade" durante o seu cadastro, você manifesta seu consentimento livre, informado e inequívoco com todas as condições aqui estabelecidas.</p>
                <p class="mb-4">O Ypy Saúde se reserva o direito de alterar estes termos a qualquer momento. Os usuários serão notificados sobre quaisquer mudanças significativas.</p>
            </article>

        </div>
    </div>
</x-layouts.public>