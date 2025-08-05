<?php

namespace App\Http\Controllers;

use App\Models\Atestado;
use App\Models\Laudo;
use App\Models\Prescricao;
use Illuminate\Http\Request;

class ValidacaoController extends Controller
{
    /**
     * Mostra um documento para validação pública.
     */
    public function show($tipo, $hash)
    {
        $modelMap = [
            'prescricao' => Prescricao::class,
            'atestado' => Atestado::class,
            'laudo' => Laudo::class,
        ];

        if (!isset($modelMap[$tipo])) {
            abort(404);
        }

        $model = $modelMap[$tipo];
        $documento = $model::where('hash_validacao', $hash)->firstOrFail();
        
        $documento->load(['paciente.pacienteProfile', 'medico.medicoProfile']);
        
        if ($tipo === 'prescricao') {
            $documento->load('medicamentos');
        }

        // Reutiliza a view de detalhes do médico para exibir o documento validado
        if ($tipo === 'prescricao') {
            // Futuramente, podemos criar uma view pública específica para validação.
            return view('medico.prescricoes.show', ['prescricao' => $documento]);
        } elseif ($tipo === 'atestado') {
            // Para atestados e laudos, podemos criar uma view de validação simples
            // ou redirecionar para o PDF. Por enquanto, vamos redirecionar para o PDF.
            return redirect()->route('medico.atestados.pdf', $documento);
        } elseif ($tipo === 'laudo') {
            return redirect()->route('medico.laudos.pdf', $documento);
        }

        abort(404);
    }
}
