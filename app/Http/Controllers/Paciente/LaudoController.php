<?php
namespace App\Http\Controllers\Paciente;

    use App\Http\Controllers\Controller;
    use App\Models\Laudo;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Barryvdh\DomPDF\Facade\Pdf;

    class LaudoController extends Controller
    {
        /**
         * Gera o PDF de um laudo para o paciente logado.
         */
        public function gerarPdf(Laudo $laudo)
        {
            // Verificação de segurança crucial
            if ($laudo->paciente_id !== Auth::id()) {
                abort(403, 'Acesso Não Autorizado');
            }

            $laudo->load(['paciente.pacienteProfile', 'medico.medicoProfile']);
            
            $pdf = Pdf::loadView('pdf.laudo', compact('laudo'));

            return $pdf->stream('laudo-'.$laudo->id.'.pdf');
        }
    }
    
