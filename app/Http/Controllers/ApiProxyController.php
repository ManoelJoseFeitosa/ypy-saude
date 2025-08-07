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
}
