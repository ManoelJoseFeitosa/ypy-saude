<?php
namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Laudo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

// --- Imports adicionados para o envio de e-mail ---
use Illuminate\Support\Facades\Mail;
use App\Mail\DocumentoMedicoDisponivel;

class LaudoController extends Controller
{
    /**
     * Mostra o formulário para criar um novo laudo.
     */
    public function create()
    {
        $pacientes = User::where('tipo', 'paciente')->orderBy('name')->get();
        return view('medico.laudos.create', compact('pacientes'));
    }

    /**
     * Salva o novo laudo no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'data_laudo' => ['required', 'date'],
            'descricao' => ['required', 'string'],
        ]);

        $validated['medico_id'] = Auth::id();
        $validated['hash_validacao'] = (string) Str::uuid();

        $laudo = Laudo::create($validated);

        // --- INÍCIO DO BLOCO DE ENVIO DE E-MAIL ---
        try {
            $paciente = User::find($validated['paciente_id']);
            $medico = Auth::user();

            Mail::to($paciente->email)->send(new DocumentoMedicoDisponivel(
                $paciente,
                $medico,
                'Laudo',      // Tipo do documento
                $laudo->id    // ID do documento para gerar a URL
            ));

        } catch (\Exception $e) {
            \Log::error('Falha ao enviar e-mail de notificação de laudo: ' . $e->getMessage());
        }
        // --- FIM DO BLOCO DE ENVIO DE E-MAIL ---

        return redirect()->route('medico.dashboard')->with('success', 'Laudo gerado com sucesso!');
    }

    /**
    * Gera o PDF de um laudo específico.
    */
    public function gerarPdf(Laudo $laudo)
    {
        if (Auth::id() !== $laudo->medico_id) {
            abort(403);
        }

        $laudo->load(['paciente.pacienteProfile', 'medico.medicoProfile']);

        $pdf = Pdf::loadView('pdf.laudo', ['laudo' => $laudo]);

        return $pdf->stream('laudo-'.$laudo->id.'.pdf');
    }
}
