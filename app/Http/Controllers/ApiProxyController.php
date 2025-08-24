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
     * Procura medicamentos na base de dados local.
     */
    public function searchMedicamentos(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3',
        ]);

        $termoBusca = $request->input('q');

        $resultados = Medicamento::where('nome', 'LIKE', "%{$termoBusca}%")
            ->limit(10) // Limita a 10 resultados para não sobrecarregar
            ->pluck('nome'); // Retorna apenas a coluna 'nome'

        return response()->json($resultados);
    }
}
