<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Laudo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'conteudo' => ['required', 'string'],
        ]);

        $laudo = Laudo::create([
            'medico_id' => Auth::id(),
            'paciente_id' => $validated['paciente_id'],
            'titulo' => $validated['titulo'],
            'conteudo' => $validated['conteudo'],
            'data_emissao' => now(),
            'hash_validacao' => (string) Str::uuid(),
        ]);

        // Redireciona diretamente para a geração do PDF
        return redirect()->route('medico.laudos.pdf', $laudo);
    }

    /**
     * Gera o PDF de um laudo.
     */
    public function gerarPdf(Laudo $laudo)
    {
        if ($laudo->medico_id !== Auth::id()) {
            abort(403);
        }

        $laudo->load(['paciente.pacienteProfile', 'medico.medicoProfile']);
        
        $pdf = Pdf::loadView('pdf.laudo', compact('laudo'));

        return $pdf->stream('laudo-'.$laudo->id.'.pdf');
    }
}
