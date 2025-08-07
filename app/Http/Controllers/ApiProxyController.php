<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiProxyController extends Controller
{
    /**
     * Busca por códigos CID em uma API externa.
     */
    public function searchCid(Request $request)
    {
        $searchTerm = $request->query('term');

        if (!$searchTerm || strlen($searchTerm) < 2) {
            return response()->json([]);
        }

        try {
            // Adicionada a diretiva withoutVerifying() para evitar problemas de SSL
            $response = Http::withoutVerifying()->get("https://cid.api.mokasoft.org/cid10/search/{$searchTerm}");

            if (!$response->successful()) {
                Log::error('Falha na API de CID: ', $response->json());
                return response()->json(['error' => 'Serviço de busca de CID indisponível'], 500);
            }

            $results = collect($response->json())->map(function ($item) {
                return [
                    'codigo' => $item->codigo,
                    'descricao' => $item->nome,
                ];
            });

            return response()->json($results);

        } catch (\Exception $e) {
            Log::error('Exceção na busca de CID: ' . $e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro interno na busca de CID'], 500);
        }
    }

    /**
     * Busca por medicamentos em uma API externa (bula.io) e retorna apenas os nomes.
     */
    public function searchMedicamentos(Request $request)
    {
        $searchTerm = $request->query('term');

        if (!$searchTerm || strlen($searchTerm) < 3) {
            return response()->json([]);
        }

        try {
            // ---- CORREÇÃO APLICADA AQUI ----
            // Adicionada a diretiva withoutVerifying() para evitar problemas de SSL
            $response = Http::withoutVerifying()->get('https://bula.io/api/search/medicamentos', [
                'nome' => $searchTerm,
                'num_docs' => 15
            ]);

            if (!$response->successful()) {
                Log::error('Falha na API de medicamentos: ', $response->json());
                return response()->json(['error' => 'Serviço de busca de medicamentos indisponível'], 500);
            }

            $results = $response->json()['results'];

            $medicamentos = collect($results)->map(function ($medicamento) {
                return $medicamento['nome'];
            })->unique()->values();

            return response()->json($medicamentos);

        } catch (\Exception $e) {
            Log::error('Exceção na busca de medicamentos: ' . $e->getMessage());
            return response()->json(['error' => 'Ocorreu um erro interno na busca de medicamentos'], 500);
        }
    }

    /**
     * Busca por médicos cadastrados na plataforma.
     */
    public function searchMedicos(Request $request)
    {
        // ... (seu código aqui, sem alterações)
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
