<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Prescricao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class PrescricaoController extends Controller
{
    /**
     * Mostra o formulário para criar uma nova prescrição.
     */
    public function create()
    {
        $pacientes = User::where('tipo', 'paciente')->orderBy('name')->get();

        return view('medico.prescricoes.create', [
            'pacientes' => $pacientes,
        ]);
    }

    /**
     * Salva a nova prescrição no banco de dados.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validação dos dados que chegam do formulário
        $validated = $request->validate([
            'paciente_id' => ['required', 'exists:users,id'],
            'medicamentos' => ['required', 'array', 'min:1'],
            'medicamentos.*.nome_medicamento' => ['required', 'string', 'max:255'],
            'medicamentos.*.dosagem' => ['required', 'string', 'max:255'],
            'medicamentos.*.quantidade' => ['required', 'string', 'max:255'],
            'medicamentos.*.posologia' => ['required', 'string'],
        ]);

        // 2. Criação da Prescrição "Cabeçalho"
        $prescricao = Prescricao::create([
            'medico_id' => Auth::id(), // Pega o ID do médico logado
            'paciente_id' => $validated['paciente_id'],
            'data_prescricao' => now(), // Define a data e hora atuais
            'hash_validacao' => (string) Str::uuid(),
        ]);

        // 3. Loop para salvar cada um dos medicamentos
        foreach ($validated['medicamentos'] as $medicamentoData) {
            // Usamos o relacionamento que definimos no Model para criar o medicamento
            $prescricao->medicamentos()->create([
                'nome_medicamento' => $medicamentoData['nome_medicamento'],
                'dosagem' => $medicamentoData['dosagem'],
                'quantidade' => $medicamentoData['quantidade'],
                'posologia' => $medicamentoData['posologia'],
            ]);
        }

        // 4. Redirecionamento com uma mensagem de sucesso
        return redirect()->route('medico.dashboard')->with('success', 'Prescrição gerada com sucesso!');
    }

    /**
     * Mostra os detalhes de uma prescrição específica.
     */
    public function show(Prescricao $prescricao)
    {
        // Garante que apenas o médico que criou a prescrição possa vê-la
        if (Auth::id() !== $prescricao->medico_id) {
            abort(403); // Acesso negado
        }

        // Carrega os dados relacionados para otimização
        $prescricao->load(['paciente.pacienteProfile', 'medico.medicoProfile', 'medicamentos']);

        return view('medico.prescricoes.show', [
            'prescricao' => $prescricao
        ]);
    }

    /**
 * Gera o PDF de uma prescrição específica.
 */
    public function gerarPdf(Prescricao $prescricao)
    {
          // Garante que apenas o médico que criou a prescrição possa gerar o PDF
            if (Auth::id() !== $prescricao->medico_id) {
            abort(403);
            }

    // Carrega todos os dados necessários
    $prescricao->load(['paciente.pacienteProfile', 'medico.medicoProfile', 'medicamentos']);

    // Gera o PDF usando a biblioteca e a nossa view de PDF
    $pdf = Pdf::loadView('pdf.prescricao', [
        'prescricao' => $prescricao
    ]);

    // Retorna o PDF para ser exibido no navegador
    return $pdf->stream('prescricao-'.$prescricao->id.'.pdf');
    }
}