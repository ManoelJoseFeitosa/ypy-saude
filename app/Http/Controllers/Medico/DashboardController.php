<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa a classe de autenticação

class DashboardController extends Controller
{
    /**
     * Exibe o painel de controle do médico.
     */
    public function index()
    {
        // Pega o usuário (médico) atualmente logado
        $medico = Auth::user();

        // Usa o relacionamento 'prescricoesEmitidas' que definimos no Model User
        // para buscar as prescrições do médico.
        $prescricoes = $medico->prescricoesEmitidas()
                             ->with('paciente') // Otimização: já carrega os dados do paciente junto
                             ->latest() // Ordena para mostrar as mais recentes primeiro
                             ->paginate(10); // Mostra 10 resultados por página

        // Retorna a view, agora enviando a variável '$prescricoes' com os dados
        return view('medico.dashboard', [
            'prescricoes' => $prescricoes
        ]);
    }
}