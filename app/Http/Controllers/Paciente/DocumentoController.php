<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Atestado;
use App\Models\Laudo;
use App\Models\Prescricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    /**
     * Mostra um documento específico (prescrição, atestado ou laudo) para o paciente.
     */
    public function show(string $tipo, int $id)
    {
        $documento = null;
        $pacienteId = Auth::id();

        // Encontra o documento com base no tipo
        switch ($tipo) {
            case 'prescrição':
                $documento = Prescricao::find($id);
                break;
            case 'atestado':
                // Supondo que você tenha um modelo Atestado
                $documento = Atestado::find($id);
                break;
            case 'laudo':
                 // Supondo que você tenha um modelo Laudo
                $documento = Laudo::find($id);
                break;
            default:
                // Tipo de documento inválido
                abort(404);
        }

        // Verifica se o documento foi encontrado e se pertence ao paciente logado
        if (!$documento || $documento->paciente_id !== $pacienteId) {
            // Se não encontrou ou o dono é outro, nega o acesso
            abort(403, 'Acesso não autorizado.');
        }

        // Carrega os dados relacionados para a view
        $documento->load(['paciente.pacienteProfile', 'medico.medicoProfile']);

        // Retorna a view, passando o documento e o tipo
        return view('paciente.documentos.show', [
            'documento' => $documento,
            'tipo' => $tipo,
        ]);
    }
}
