<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescrição Médica</title>
    <style>
        /* Estilos para o PDF - use estilos simples e compatíveis */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 40px;
        }
        .header, .footer {
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #0056b3; /* Tom de azul */
        }
        .header p {
            margin: 2px 0;
            font-size: 11px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
            margin-bottom: 5px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
        }
        .patient-info, .medicamentos-info {
            margin-bottom: 20px;
        }
        .medicamento {
            margin-bottom: 15px;
            padding-left: 10px;
        }
        .medicamento-nome {
            font-weight: bold;
        }
        .footer {
            position: fixed;
            bottom: 40px;
            left: 0;
            right: 0;
            font-size: 10px;
            color: #777;
        }
        .signature-line {
            border-top: 1px solid #333;
            width: 250px;
            margin: 60px auto 5px auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        {{-- Cabeçalho com informações do Médico --}}
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

        {{-- Rodapé com Data e Assinatura --}}
        <div class="footer">
            <p>Data de Emissão: {{ \Carbon\Carbon::parse($prescricao->data_prescricao)->format('d/m/Y \à\s H:i') }}</p>
            
            <div class="signature-line">
                {{ $prescricao->medico->name }}
            </div>
            <p>Assinado Digitalmente</p>
            <p style="margin-top: 10px;">Valide este documento em: {{ url('/validar/prescricao/' . $prescricao->hash_validacao) }}</p>
        </div>

    </div>
</body>
</html>
