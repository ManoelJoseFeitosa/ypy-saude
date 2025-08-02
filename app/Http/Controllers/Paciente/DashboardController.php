<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Exibe o painel de controle do paciente com seu histórico de prescrições.
     */
    public function index()
    {
        $paciente = Auth::user();

        // Usa o relacionamento 'prescricoesRecebidas' que definimos no Model User
        $prescricoes = $paciente->prescricoesRecebidas()
                              ->with('medico.medicoProfile') // Carrega os dados do médico junto para otimizar
                              ->latest('data_prescricao') // Ordena pelas mais recentes
                              ->paginate(10); // Divide em páginas

        // Retorna a view do painel do paciente, enviando a lista de prescrições
        return view('paciente.dashboard', [
            'prescricoes' => $prescricoes,
        ]);
    }
}
