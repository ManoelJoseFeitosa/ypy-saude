<?php

namespace App\Http\Controllers;

use App\Models\Prescricao;
use Illuminate\Http\Request;

class PrescricaoPublicController extends Controller
{
    /**
     * Mostra uma prescrição para validação pública usando o hash.
     */
    public function show($hash)
    {
        // Busca a prescrição pelo código de validação. Se não encontrar, retorna erro 404.
        $prescricao = Prescricao::where('hash_validacao', $hash)->firstOrFail();

        // Carrega os dados relacionados para a view
        $prescricao->load(['paciente.pacienteProfile', 'medico.medicoProfile', 'medicamentos']);

        // Vamos reutilizar a view de detalhes que já temos!
        return view('medico.prescricoes.show', [
            'prescricao' => $prescricao
        ]);
    }
}
