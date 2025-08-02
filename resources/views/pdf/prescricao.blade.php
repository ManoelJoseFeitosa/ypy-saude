<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Prescrição Médica</title>
    <style>
        body { font-family: 'Dejavu Sans', sans-serif; margin: 0; padding: 40px; color: #333; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #002e7a; padding-bottom: 15px; }
        .header h1 { margin: 0; color: #002e7a; font-size: 24px; }
        .header p { margin: 5px 0 0; }
        .section { margin-top: 25px; }
        .section h2 { font-size: 14px; color: #002e7a; border-bottom: 1px solid #ccc; padding-bottom: 5px; margin-bottom: 10px; }
        .info-grid { width: 100%; border-collapse: collapse; }
        .info-grid td { padding: 8px 0; vertical-align: top; }
        .info-grid .label { font-weight: bold; width: 120px; }
        .medicamentos-list { margin-top: 15px; }
        .medicamento-item { padding: 10px; border: 1px solid #eee; margin-bottom: 10px; page-break-inside: avoid; }
        .medicamento-item .nome { font-size: 14px; font-weight: bold; }
        .footer { position: fixed; bottom: 80px; left: 40px; right: 40px; text-align: center; }
        .signature p { margin: 0; }
        .qr-code { position: fixed; bottom: 40px; right: 40px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ypy Saúde</h1>
        <p>Prescrição Médica Digital</p>
    </div>

    <div class="section">
        <h2>Dados do Paciente</h2>
        <table class="info-grid">
            <tr>
                <td class="label">Nome:</td>
                <td>{{ $prescricao->paciente->name }}</td>
            </tr>
            @if($prescricao->paciente->pacienteProfile)
            <tr>
                <td class="label">CPF:</td>
                <td>{{ $prescricao->paciente->pacienteProfile->cpf }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h2>Medicamentos Prescritos</h2>
        <div class="medicamentos-list">
            @foreach ($prescricao->medicamentos as $medicamento)
            <div class="medicamento-item">
                <p class="nome">{{ $medicamento->nome_medicamento }}</p>
                <p><strong>Dosagem:</strong> {{ $medicamento->dosagem }}</p>
                <p><strong>Quantidade:</strong> {{ $medicamento->quantidade }}</p>
                <p><strong>Instruções:</strong> {{ $medicamento->posologia }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <div class="footer">
        <div class="signature">
            <p>_________________________________________</p>
            <p>Dr(a). {{ $prescricao->medico->name }}</p>
            <p>CRM: {{ $prescricao->medico->medicoProfile->crm }}/{{ $prescricao->medico->medicoProfile->uf_crm }}</p>
        </div>
    </div>

@if($prescricao->hash_validacao)
    <div class="qr-code">
        @php
            $qrCodeSvg = QrCode::size(80)->generate(route('prescricao.validar.show', $prescricao->hash_validacao));
            $qrCodeBase64 = base64_encode($qrCodeSvg);
        @endphp
        <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}">
        
        <p style="font-size: 8px; margin-top: 5px; word-wrap: break-word;">
            Valide esta prescrição em:<br>
            <strong>{{ $prescricao->hash_validacao }}</strong>
        </p>
    </div>
@endif
</body>
</html>