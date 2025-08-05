<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\HorarioDisponivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    /**
     * Mostra a página de gestão de horários do médico.
     */
    public function index()
    {
        $horarios = Auth::user()->horariosDisponiveis()->orderBy('dia_semana')->orderBy('hora_inicio')->get();

        $diasSemana = [
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
            0 => 'Domingo',
        ];

        return view('medico.horarios.index', compact('horarios', 'diasSemana'));
    }

    /**
     * Salva um novo horário de atendimento.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dia_semana' => ['required', 'integer', 'between:0,6'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fim' => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'duracao_consulta' => ['required', 'integer', 'min:10'],
        ]);

        Auth::user()->horariosDisponiveis()->create($validated);

        return back()->with('success', 'Horário adicionado com sucesso!');
    }

    /**
     * Remove um horário de atendimento.
     */
    public function destroy(HorarioDisponivel $horario)
    {
        // Garante que o médico só pode apagar os seus próprios horários
        if ($horario->medico_id !== Auth::id()) {
            abort(403);
        }

        $horario->delete();

        return back()->with('success', 'Horário removido com sucesso!');
    }
}

