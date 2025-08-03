<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Atestado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class AtestadoController extends Controller
{
    /**
     * Mostra o formulário para criar um novo atestado.
     */
    public function create()
    {
        $pacientes = User::where('tipo', 'paciente')->orderBy('name')->get();
        return view('medico.atestados.create', ['pacientes' => $pacientes]);
    }

    /**
     * Salva o novo atestado no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'dias_afastamento' => ['required', 'integer', 'min:1'],
            'cid' => ['nullable', 'string', 'max:10'],
            'motivo' => ['required', 'string'],
        ]);

        $atestado = Atestado::create([
            'medico_id' => Auth::id(),
            'paciente_id' => $validated['paciente_id'],
            'dias_afastamento' => $validated['dias_afastamento'],
            'cid' => $validated['cid'],
            'motivo' => $validated['motivo'],
            'data_emissao' => now(),
            'hash_validacao' => (string) Str::uuid(),
        ]);

        // Redireciona para a geração do PDF
        return redirect()->route('medico.atestados.pdf', $atestado);
    }

    /**
     * Gera o PDF de um atestado.
     */
    public function gerarPdf(Atestado $atestado)
    {
        // Garante que apenas o médico que criou o atestado possa vê-lo
        if ($atestado->medico_id !== Auth::id()) {
            abort(403);
        }

        $atestado->load(['paciente.pacienteProfile', 'medico.medicoProfile']);
        
        $pdf = Pdf::loadView('pdf.atestado', ['atestado' => $atestado]);

        return $pdf->stream('atestado-'.$atestado->id.'.pdf');
    }
}