<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Prescricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescricaoController extends Controller
{
    /**
     * Mostra os detalhes de uma prescrição específica.
     */
    public function show(Prescricao $prescricao)
    {
        // ===== VERIFICAÇÃO DE SEGURANÇA CRÍTICA =====
        // Garante que o ID do paciente logado é o mesmo ID do paciente na prescrição.
        // Isso impede que um paciente veja a prescrição de outro.
        if ($prescricao->paciente_id !== Auth::id()) {
            abort(403, 'Acesso Não Autorizado');
        }

        // Carrega os dados relacionados para a view
        $prescricao->load(['paciente.pacienteProfile', 'medico.medicoProfile', 'medicamentos']);

        // Reutiliza a mesma view de detalhes que o médico usa!
        return view('medico.prescricoes.show', [
            'prescricao' => $prescricao
        ]);
    }
}