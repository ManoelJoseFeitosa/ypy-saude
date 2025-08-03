<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Exibe o painel de controle do paciente com seu histórico de prescrições e atestados.
     */
    public function index()
    {
        $paciente = Auth::user();

        // Busca as prescrições do paciente
        $prescricoes = $paciente->prescricoesRecebidas()
                              ->with('medico')
                              ->latest('data_prescricao')
                              ->paginate(5, ['*'], 'prescricoes_page');

        // Busca os atestados do paciente (ESTA PARTE ESTAVA FALTANDO)
        $atestados = $paciente->atestadosRecebidos()
                                    ->with('medico')
                                    ->latest('data_emissao')
                                    ->paginate(5, ['*'], 'atestados_page');

        // Retorna a view, agora enviando AMBAS as listas de dados
        return view('paciente.dashboard', [
            'prescricoes' => $prescricoes,
            'atestados'   => $atestados, // Envia a variável $atestados para a view
        ]);
    }
}