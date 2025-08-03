<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Atestado Médico</title>
    <style>
        body { font-family: 'Dejavu Sans', sans-serif; padding: 50px; font-size: 14px; line-height: 1.8; color: #333; }
        .header { text-align: center; }
        .header h1 { font-size: 28px; margin-bottom: 30px; color: #002e7a; }
        .content { margin-top: 50px; text-align: justify; }
        .date-location { text-align: center; margin-top: 60px; margin-bottom: 80px; }
        .signature { text-align: center; }
        .signature p { margin: 0; }
        .qr-code-validation { position: fixed; bottom: 40px; right: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ATESTADO MÉDICO</h1>
    </div>

    <div class="content">
        <p>
            Atesto, para os devidos fins, que o(a) Sr(a). <strong>{{ $atestado->paciente->name }}</strong>
            @if($atestado->paciente->pacienteProfile && $atestado->paciente->pacienteProfile->cpf)
                , portador(a) do CPF nº <strong>{{ $atestado->paciente->pacienteProfile->cpf }}</strong>
            @endif
            , esteve sob meus cuidados médicos na data de hoje, necessitando de afastamento de suas atividades laborais
            por um período de <strong>{{ $atestado->dias_afastamento }}</strong>
            ({{ \App\Helpers\NumeroPorExtenso::converter($atestado->dias_afastamento) }})
            dia(s), a contar desta data.
            @if($atestado->cid)
                CID: <strong>{{ $atestado->cid }}</strong>.
            @endif
        </p>
        <p><strong>Motivo:</strong> {{ $atestado->motivo }}</p>
    </div>

    <div class="date-location">
        <p>Teresina, {{ \Carbon\Carbon::parse($atestado->data_emissao)->translatedFormat('d \de F \de Y') }}.</p>
    </div>

    <div class="signature">
        <p>_________________________________________</p>
        <p>Dr(a). {{ $atestado->medico->name }}</p>
        <p>CRM: {{ $atestado->medico->medicoProfile->crm }}/{{ $atestado->medico->medicoProfile->uf_crm }}</p>
    </div>

    {{-- BLOCO DO QR CODE COM A CORREÇÃO DEFINITIVA --}}
    @if($atestado->hash_validacao)
        <div class="qr-code-validation">
            @php
                $validationUrl = route('prescricao.validar.show', $atestado->hash_validacao);
                // 1. Gera o QR Code em SVG (formato padrão, não precisa de extensões)
                $qrCodeSvg = QrCode::size(80)->generate($validationUrl);
                // 2. Converte para base64
                $qrCodeBase64 = base64_encode($qrCodeSvg);
            @endphp
            {{-- 3. Exibe em uma tag <img> --}}
            <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}">
            <p style="font-size: 8px; margin-top: 5px; word-wrap: break-word;">
                <strong>{{ $atestado->hash_validacao }}</strong>
            </p>
        </div>
    @endif
</body>
</html>