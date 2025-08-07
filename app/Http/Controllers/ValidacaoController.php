<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescricao;
use App\Models\Atestado;
use App\Models\Laudo;

class ValidacaoController extends Controller
{
    /**
     * Mostra a página de validação pública para um documento.
     */
    public function show(Request $request, string $tipo, string $hash)
    {
        $documento = null;

        // Encontra o documento correto com base no tipo, já carregando os dados relacionados
        switch ($tipo) {
            case 'prescricao':
                $documento = Prescricao::where('hash_validacao', $hash)
                    ->with(['medico.medicoProfile', 'paciente'])
                    ->firstOrFail(); // firstOrFail() retorna 404 automaticamente se não encontrar
                break;
            case 'atestado':
                $documento = Atestado::where('hash_validacao', $hash)
                    ->with(['medico.medicoProfile', 'paciente'])
                    ->firstOrFail();
                break;
            case 'laudo':
                $documento = Laudo::where('hash_validacao', $hash)
                    ->with(['medico.medicoProfile', 'paciente'])
                    ->firstOrFail();
                break;
            default:
                abort(404); // Se o tipo for inválido, retorna 404
        }

        // Passa o documento e o tipo para a view de validação pública que você criou
        return view('validacao.show', [
            'documento' => $documento,
            'tipo' => $tipo,
        ]);
    }
}
