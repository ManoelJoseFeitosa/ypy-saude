<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescrição Médica</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; margin: 0; padding: 0; }
        .container { padding: 40px; }
        .header, .footer-content { text-align: center; }
        .header h1 { margin: 0; font-size: 20px; color: #0056b3; }
        .header p { margin: 2px 0; font-size: 11px; }
        .section-title { font-weight: bold; font-size: 14px; margin-top: 20px; margin-bottom: 5px; border-bottom: 1px solid #ccc; padding-bottom: 3px; }
        .patient-info, .medicamentos-info { margin-bottom: 20px; }
        .medicamento { margin-bottom: 15px; padding-left: 10px; }
        .medicamento-nome { font-weight: bold; }
        .footer { position: fixed; bottom: 40px; left: 40px; right: 40px; display: table; width: 100%; }
        .footer-cell { display: table-cell; vertical-align: bottom; }
        .qr-code { text-align: left; width: 100px; }
        .footer-content { text-align: right; font-size: 10px; color: #777; }
        .signature-line { border-top: 1px solid #333; width: 250px; margin: 60px auto 5px auto; padding-top: 5px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        
        {{-- Cabeçalho --}}
        <div class="header">
            <h1>{{ $prescricao->medico->name }}</h1>
            <p>{{ $prescricao->medico->medicoProfile->especialidade ?? 'Clínico Geral' }}</p>
            <p>CRM: {{ $prescricao->medico->medicoProfile->crm }} / {{ $prescricao->medico->medicoProfile->uf_crm }}</p>
            <p>{{ $prescricao->medico->medicoProfile->endereco_completo }}</p>
        </div>

        {{-- Informações do Paciente --}}
        <div class="patient-info">
            <p class="section-title">Paciente</p>
            <p><strong>Nome:</strong> {{ $prescricao->paciente->name }}</p>
        </div>

        {{-- Lista de Medicamentos --}}
        <div class="medicamentos-info">
            <p class="section-title">Prescrição</p>
            @foreach ($prescricao->medicamentos as $index => $medicamento)
                <div class="medicamento">
                    <p><span class="medicamento-nome">{{ $index + 1 }}. {{ $medicamento->nome_medicamento }}</span> - {{ $medicamento->dosagem }}</p>
                    <p><strong>Quantidade:</strong> {{ $medicamento->quantidade }}</p>
                    <p><strong>Posologia:</strong> {{ $medicamento->posologia }}</p>
                </div>
            @endforeach
        </div>

        {{-- Linha de Assinatura (para visualização) --}}
        <div class="signature-line">
            {{ $prescricao->medico->name }}
        </div>
        <p style="text-align: center;">Assinado Digitalmente</p>
        
        {{-- Rodapé --}}
        <div class="footer">
            <div class="footer-cell qr-code">
                {{-- QR CODE ADICIONADO AQUI --}}
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(80)->generate($validationUrl)) !!} ">
            </div>
            <div class="footer-cell footer-content">
                <p>Data de Emissão: {{ \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d/m/Y \à\s H:i') }}</p>
                <p style="margin-top: 10px;">Valide este documento em: {{ $validationUrl }}</p>
            </div>
        </div>

    </div>
</body>
</html>
