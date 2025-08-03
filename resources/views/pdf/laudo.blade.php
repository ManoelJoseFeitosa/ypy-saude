<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laudo Médico</title>
    <style>
        body { font-family: 'Dejavu Sans', sans-serif; padding: 50px; font-size: 12px; line-height: 1.6; color: #333; }
        .header { text-align: center; }
        .header h1 { font-size: 24px; margin-bottom: 5px; color: #002e7a; }
        .header h2 { font-size: 18px; font-weight: normal; margin: 0; }
        .info-section { margin-top: 30px; border: 1px solid #ccc; padding: 15px; }
        .info-section p { margin: 0 0 8px 0; }
        /* CORREÇÃO: Removido 'text-align: justify' e 'white-space: pre-wrap' */
        .content { margin-top: 30px; }
        .signature { margin-top: 80px; text-align: center; }
        .qr-code-validation { position: fixed; bottom: 40px; right: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAUDO MÉDICO</h1>
        <h2>{{ $laudo->titulo }}</h2>
    </div>

    <div class="info-section">
        <p><strong>Paciente:</strong> {{ $laudo->paciente->name }}</p>
        @if($laudo->paciente->pacienteProfile)
            <p><strong>CPF:</strong> {{ $laudo->paciente->pacienteProfile->cpf }}</p>
        @endif
        <p><strong>Data de Emissão:</strong> {{ $laudo->data_emissao->format('d/m/Y') }}</p>
    </div>

    <div class="content">
        {!! nl2br(e($laudo->conteudo)) !!}
    </div>

    <div class="signature">
        <p>_________________________________________</p>
        <p>Dr(a). {{ $laudo->medico->name }}</p>
        <p>CRM: {{ $laudo->medico->medicoProfile->crm }}/{{ $laudo->medico->medicoProfile->uf_crm }}</p>
    </div>

    @if($laudo->hash_validacao)
        <div class="qr-code-validation">
            @php
                $validationUrl = route('laudo.validar.show', $laudo->hash_validacao);
                $qrCodeSvg = QrCode::size(80)->generate($validationUrl);
                $qrCodeBase64 = base64_encode($qrCodeSvg);
            @endphp
            <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}">
            <p style="font-size: 8px; margin-top: 5px; word-wrap: break-word;">
                <strong>{{ $laudo->hash_validacao }}</strong>
            </p>
        </div>
    @endif
</body>
</html>
