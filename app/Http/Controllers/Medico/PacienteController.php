<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    /**
     * Lista todos os pacientes atendidos pelo médico logado.
     */
    public function index()
    {
        $medico = Auth::user();

        // Pega os IDs dos pacientes de prescrições e atestados
        $prescricoesPacienteIds = $medico->prescricoesEmitidas()->pluck('paciente_id');
        $atestadosPacienteIds = $medico->atestadosEmitidos()->pluck('paciente_id');

        // Junta e pega apenas os IDs únicos
        $pacienteIds = $prescricoesPacienteIds->merge($atestadosPacienteIds)->unique();

        // Busca os pacientes
        $pacientes = User::whereIn('id', $pacienteIds)->orderBy('name')->paginate(15);

        return view('medico.pacientes.index', compact('pacientes'));
    }

    /**
     * Mostra o prontuário e histórico de um paciente específico.
     */
    public function show(User $paciente)
    {
        $medico = Auth::user();

        // Carrega o histórico do paciente relacionado a este médico
        $paciente->load([
            'pacienteProfile',
            'prescricoesRecebidas' => fn ($query) => $query->where('medico_id', $medico->id)->latest(),
            'atestadosRecebidos' => fn ($query) => $query->where('medico_id', $medico->id)->latest(),
            'prontuarios' => fn ($query) => $query->where('medico_id', $medico->id)->latest(),
        ]);

        return view('medico.pacientes.show', compact('paciente'));
    }

    /**
     * Salva uma nova anotação no prontuário do paciente.
     */
    public function storeProntuario(Request $request, User $paciente)
    {
        $request->validate([
            'anotacao' => 'required|string',
        ]);

        $paciente->prontuarios()->create([
            'medico_id' => Auth::id(),
            'data_atendimento' => now(),
            'anotacao' => $request->anotacao,
        ]);

        return back()->with('success', 'Anotação salva no prontuário com sucesso!');
    }
}
