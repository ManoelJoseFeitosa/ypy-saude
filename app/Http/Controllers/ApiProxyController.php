<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiProxyController extends Controller
{
    /**
     * Busca por médicos cadastrados na plataforma.
     * Este método é mantido para buscas públicas, se necessário.
     */
    public function searchMedicos(Request $request)
    {
        try {
            $query = $request->input('q');

            if (strlen($query) < 3) {
                return response()->json([]);
            }

            $medicos = User::where('tipo', 'medico')
                            ->whereHas('medicoProfile')
                            ->where('name', 'LIKE', "%{$query}%")
                            ->with('medicoProfile')
                            ->limit(10)
                            ->get();

            return response()->json($medicos);

        } catch (\Exception $e) {
            Log::error('Erro ao buscar médicos: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    /**
     * Procura medicamentos na base de dados local de forma insensível a maiúsculas/minúsculas.
     */
    public function searchMedicamentos(Request $request)
    {
        $request->validate([
            'q' => 'sometimes|string|min:3',
        ]);

        $termoBusca = $request->input('q');

        if (!$termoBusca) {
            return response()->json(['items' => []]);
        }

        // --- LÓGICA DE BUSCA CORRIGIDA COM whereRaw ---
        // Esta abordagem é mais direta e robusta para buscas case-insensitive.
        $resultados = Medicamento::whereRaw('LOWER(nome) LIKE ?', ['%' . strtolower($termoBusca) . '%'])
            ->limit(20)
            ->get(['id', 'nome'])
            ->map(function ($medicamento) {
                return ['value' => $medicamento->nome, 'text' => $medicamento->nome];
            });

        return response()->json(['items' => $resultados]);
    }
}
