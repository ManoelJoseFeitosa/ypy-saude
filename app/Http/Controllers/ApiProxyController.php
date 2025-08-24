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
        $termoBusca = $request->input('q');

        // --- LOG DE DIAGNÓSTICO 1 ---
        // Regista o termo de busca que o servidor recebeu.
        Log::info('[Busca Medicamento] Termo recebido: ' . $termoBusca);

        if (!$termoBusca || strlen($termoBusca) < 3) {
            return response()->json(['items' => []]);
        }

        // A lógica de busca que já tínhamos
        $resultados = Medicamento::whereRaw('nome COLLATE utf8mb4_unicode_ci LIKE ?', ['%' . $termoBusca . '%'])
            ->limit(20)
            ->get(['id', 'nome']);

        // --- LOG DE DIAGNÓSTICO 2 ---
        // Regista quantos resultados a consulta à base de dados encontrou.
        Log::info('[Busca Medicamento] Resultados encontrados: ' . $resultados->count());

        $mappedResults = $resultados->map(function ($medicamento) {
            return ['value' => $medicamento->nome, 'text' => $medicamento->nome];
        });
        return response()->json(['items' => $mappedResults]);
    }
}
