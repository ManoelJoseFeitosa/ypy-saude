<?php
namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Atestado;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

// --- Imports adicionados para o envio de e-mail ---
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentoMedicoDisponivel;

class AtestadoController extends Controller
{
    /**
     * Mostra o formulário para criar um novo atestado.
     */
    public function create()
    {
        $pacientes = User::where('tipo', 'paciente')->orderBy('name')->get();
        return view('medico.atestados.create', compact('pacientes'));
    }

    /**
     * Salva o novo atestado no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'data_atestado' => ['required', 'date'],
            'dias_afastamento' => ['nullable', 'integer', 'min:0'],
            'cid' => ['nullable', 'string', 'max:10'],
            'observacoes' => ['required', 'string'],
        ]);

        $validated['medico_id'] = Auth::id();
        $validated['hash_validacao'] = (string) Str::uuid();

        $atestado = Atestado::create($validated);

        // --- INÍCIO DO BLOCO DE ENVIO DE E-MAIL ---
        try {
            $paciente = User::find($validated['paciente_id']);
            $medico = Auth::user();

            Mail::to($paciente->email)->send(new DocumentoMedicoDisponivel(
                $paciente,
                $medico,
                'Atestado',      // Tipo do documento
                $atestado->id    // ID do documento para gerar a URL
            ));

        } catch (\Exception $e) {
            \Log::error('Falha ao enviar e-mail de notificação de atestado: ' . $e->getMessage());
        }
        // --- FIM DO BLOCO DE ENVIO DE E-MAIL ---

        return redirect()->route('medico.dashboard')->with('success', 'Atestado gerado com sucesso!');
    }

    /**
    * Gera o PDF de um atestado específico.
    */
    public function gerarPdf(Atestado $atestado)
    {
        if (Auth::id() !== $atestado->medico_id) {
            abort(403);
        }

        $atestado->load(['paciente.pacienteProfile', 'medico.medicoProfile']);

        $pdf = Pdf::loadView('pdf.atestado', ['atestado' => $atestado]);

        return $pdf->stream('atestado-'.$atestado->id.'.pdf');
    }
}
