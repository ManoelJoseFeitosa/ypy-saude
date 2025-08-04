<x-mail::message>
# Olá, {{ $paciente->name }}!

Um novo documento médico foi emitido para você em nossa plataforma Ypy Saúde.

**Tipo do Documento:** {{ ucfirst($tipoDocumento) }}
**Emitido por:** Dr(a). {{ $medico->name }}

Para sua conveniência e segurança, você pode visualizar e baixar o documento diretamente através do link abaixo:

<x-mail::button :url="$url">
Visualizar Documento
</x-mail::button>

Se você não estava esperando este documento, por favor, entre em contato com o(a) médico(a) ou com nosso suporte.

Atenciosamente,<br>
Equipe Ypy Saúde
</x-mail::message>