<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Prescricao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentoMedicoDisponivel;
use App\Http\Controllers\ZapSignController;
use Illuminate\Support\Facades\Storage;

class PrescricaoController extends Controller
{
    protected $zapsignController;

    // --- CONSTRUTOR ADICIONADO ---
    // Injeta o ZapSignController para que possamos usar seus métodos
    public function __construct(ZapSignController $zapsignController)
    {
        $this->zapsignController = $zapsignController;
    }

    /**
     * Mostra o formulário para criar uma nova prescrição.
     */
    public function create()
    {
        $pacientes = User::where('tipo', 'paciente')->orderBy('name')->get();

        return view('medico.prescricoes.create', [
            'pacientes' => $pacientes,
        ]);
    }

    /**
     * Salva a nova prescrição e a envia para assinatura digital.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validação dos dados que chegam do formulário
        $validated = $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'tipo' => ['required', 'string', 'in:simples,especial,amarela,azul'],
            'medicamentos' => ['required', 'array', 'min:1'],
            'medicamentos.*.nome_medicamento' => ['required', 'string', 'max:255'],
            'medicamentos.*.dosagem' => ['required', 'string', 'max:255'],
            'medicamentos.*.quantidade' => ['required', 'string', 'max:255'],
            'medicamentos.*.posologia' => ['required', 'string'],
        ]);

        // 2. Criação da Prescrição "Cabeçalho"
        $prescricao = Prescricao::create([
            'medico_id' => Auth::id(),
            'paciente_id' => $validated['paciente_id'],
            'data_prescricao' => now(),
            'tipo' => $validated['tipo'],
            'hash_validacao' => (string) Str::uuid(),
            // O status padrão 'pendente' já é definido na migration
        ]);

        // 3. Loop para salvar cada um dos medicamentos
        foreach ($validated['medicamentos'] as $medicamentoData) {
            $prescricao->medicamentos()->create($medicamentoData);
        }
        
        // Carrega os relacionamentos necessários para o PDF e e-mail
        $prescricao->load(['paciente', 'medico.medicoProfile', 'medicamentos']);

        // 4. Envio de e-mail de notificação para o paciente
        try {
            Mail::to($prescricao->paciente->email)->send(new DocumentoMedicoDisponivel(
                $prescricao->paciente,
                $prescricao->medico,
                'Prescrição',
                $prescricao->id
            ));
        } catch (\Exception $e) {
            \Log::error('Falha ao enviar e-mail de notificação de prescrição: ' . $e->getMessage());
        }

        // --- INÍCIO DO NOVO FLUXO DE ASSINATURA DIGITAL ---

        // 5. Gere o PDF da prescrição e salve-o temporariamente no servidor
        $pdf = Pdf::loadView('pdf.prescricao', ['prescricao' => $prescricao]);
        $pdfContent = $pdf->output();
        // Define um caminho único para o arquivo
        $documentPath = 'prescricoes/prescricao-' . $prescricao->id . '-' . time() . '.pdf';
        Storage::disk('local')->put($documentPath, $pdfContent);

        // 6. Chame o ZapSignController para enviar o documento para assinatura
        $signer = Auth::user(); // O médico logado é o assinante
        $signUrl = $this->zapsignController->sendDocumentForSignature(
            $documentPath,
            $signer,
            $prescricao // Passa o objeto da prescrição para salvar o zapsign_token
        );

        // 7. Se a URL de assinatura foi criada, redirecione o médico para lá
        if ($signUrl) {
            // Após o envio, podemos apagar o arquivo local temporário
            Storage::disk('local')->delete($documentPath);
            
            // Redireciona o médico para a página de assinatura da ZapSign
            return redirect()->away($signUrl);
        }

        // Se houver um erro na integração com a ZapSign, volte com uma mensagem de erro
        return redirect()->route('medico.dashboard')->with('error', 'Prescrição criada, mas falha ao enviar para assinatura. Por favor, contate o suporte.');
    }

    /**
     * Mostra os detalhes de uma prescrição específica.
     */
    public function show(Prescricao $prescricao)
    {
        // ... (seu código aqui, sem alterações)
        if (Auth::id() !== $prescricao->medico_id) {
            abort(403);
        }
        $prescricao->load(['paciente.pacienteProfile', 'medico.medicoProfile', 'medicamentos']);
        return view('medico.prescricoes.show', [
            'prescricao' => $prescricao
        ]);
    }

    /**
    * Gera o PDF de uma prescrição específica.
    */
    public function gerarPdf(Prescricao $prescricao)
    {
        // ... (seu código aqui, sem alterações)
        if (Auth::id() !== $prescricao->medico_id) {
            abort(403);
        }
        $prescricao->load(['paciente.pacienteProfile', 'medico.medicoProfile', 'medicamentos']);
        $pdf = Pdf::loadView('pdf.prescricao', [
            'prescricao' => $prescricao
        ]);
        return $pdf->stream('prescricao-'.$prescricao->id.'.pdf');
    }
}