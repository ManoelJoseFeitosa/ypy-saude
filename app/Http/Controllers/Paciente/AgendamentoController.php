<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{
    /**
     * Mostra uma lista de médicos para o paciente agendar.
     */
    public function index()
    {
        $medicos = User::where('tipo', 'medico')->with('medicoProfile')->paginate(10);
        return view('paciente.agendamento.index', compact('medicos'));
    }

    /**
     * Mostra a página de agendamento para um médico específico.
     */
    public function show(User $medico)
    {
        $medico->load('medicoProfile');
        return view('paciente.agendamento.show', compact('medico'));
    }

    /**
     * Busca e retorna os horários disponíveis para um médico numa data específica.
     * Esta rota é chamada via JavaScript (Fetch API).
     */
    public function fetchHorarios(Request $request, User $medico)
    {
        $request->validate(['date' => 'required|date_format:Y-m-d']);
        $dataSelecionada = Carbon::parse($request->date);
        $diaSemana = $dataSelecionada->dayOfWeek;

        // Encontra o horário de trabalho do médico para aquele dia da semana
        $horarioTrabalho = $medico->horariosDisponiveis()->where('dia_semana', $diaSemana)->first();

        if (!$horarioTrabalho) {
            return response()->json(['horarios' => []]);
        }

        // Busca as consultas já agendadas para aquele dia
        $agendamentosDoDia = Agendamento::where('medico_id', $medico->id)
            ->whereDate('data_hora_inicio', $dataSelecionada->toDateString())
            ->pluck('data_hora_inicio')
            ->map(fn ($data) => Carbon::parse($data)->format('H:i'))
            ->toArray();

        $horariosDisponiveis = [];
        $horaAtual = Carbon::parse($horarioTrabalho->hora_inicio);
        $horaFim = Carbon::parse($horarioTrabalho->hora_fim);
        $duracao = $horarioTrabalho->duracao_consulta;

        // Gera os slots de horário
        while ($horaAtual < $horaFim) {
            $horarioFormatado = $horaAtual->format('H:i');

            // Adiciona o horário à lista apenas se não estiver já agendado
            if (!in_array($horarioFormatado, $agendamentosDoDia)) {
                $horariosDisponiveis[] = $horarioFormatado;
            }
            $horaAtual->addMinutes($duracao);
        }

        return response()->json(['horarios' => $horariosDisponiveis]);
    }

    /**
     * Salva um novo agendamento.
     */
    public function store(Request $request, User $medico)
    {
        $validated = $request->validate([
            'data' => ['required', 'date_format:Y-m-d'],
            'horario' => ['required', 'date_format:H:i'],
            'notas_paciente' => ['nullable', 'string', 'max:500'],
        ]);

        $dataHoraInicio = Carbon::parse($validated['data'] . ' ' . $validated['horario']);
        
        // Encontra a duração da consulta para calcular a hora de fim
        $diaSemana = $dataHoraInicio->dayOfWeek;
        $horarioTrabalho = $medico->horariosDisponiveis()->where('dia_semana', $diaSemana)->firstOrFail();
        $dataHoraFim = $dataHoraInicio->copy()->addMinutes($horarioTrabalho->duracao_consulta);

        Agendamento::create([
            'medico_id' => $medico->id,
            'paciente_id' => Auth::id(),
            'data_hora_inicio' => $dataHoraInicio,
            'data_hora_fim' => $dataHoraFim,
            'notas_paciente' => $validated['notas_paciente'],
            'status' => 'agendado',
            'tipo' => 'teleconsulta',
            // O link da teleconsulta será gerado mais tarde
        ]);

        return redirect()->route('paciente.dashboard')->with('success', 'Consulta agendada com sucesso!');
    }
}
