<?php

namespace App\Http\Controllers\Medico;

use App\Http\Controllers\Controller;
use App\Models\Prescricao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);

        // 3. Loop para salvar cada um dos medicamentos
        foreach ($validated['medicamentos'] as $medicamentoData) {
            // Usamos o relacionamento que definimos no Model para criar o medicamento
            // O Laravel preenche o 'prescricao_id' automaticamente para nós!
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
}