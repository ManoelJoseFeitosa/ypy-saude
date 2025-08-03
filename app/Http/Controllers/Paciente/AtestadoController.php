<?php

namespace App\Http\Controllers\Paciente;

use App\Http\Controllers\Controller;
use App\Models\Atestado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AtestadoController extends Controller
{
    /**
     * Gera o PDF de um atestado para o paciente logado.
     */
    public function gerarPdf(Atestado $atestado)
    {
        // ===== VERIFICAÇÃO DE SEGURANÇA CRÍTICA =====
        // Garante que o ID do paciente logado é o mesmo do atestado solicitado.
        // Isso impede que um paciente baixe o atestado de outro.
        if ($atestado->paciente_id !== Auth::id()) {
            abort(403, 'Acesso Não Autorizado');
        }

        // Carrega os dados relacionados
        $atestado->load(['paciente.pacienteProfile', 'medico.medicoProfile']);

        // Reutiliza a mesma view de PDF que já temos para o atestado
        $pdf = Pdf::loadView('pdf.atestado', ['atestado' => $atestado]);

        return $pdf->stream('atestado-'.$atestado->id.'.pdf');
    }
}
