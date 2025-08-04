<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importa a classe de Log

class ApiProxyController extends Controller
{
    /**
     * Busca por códigos CID usando uma lista interna para desenvolvimento.
     */
    public function searchCid(Request $request)
    {
        $query = strtolower($request->input('q', ''));
        if (strlen($query) < 2) { return response()->json([]); }
        $localCidList = [
            ['codigo' => 'A09', 'descricao' => 'Diarreia e gastroenterite de origem infecciosa presumível'],
            ['codigo' => 'J11', 'descricao' => 'Influenza (gripe) com vírus não identificado'],
            ['codigo' => 'R51', 'descricao' => 'Cefaleia (dor de cabeça)'],
        ];
        $results = array_filter($localCidList, function ($item) use ($query) {
            return str_contains(strtolower($item['codigo']), $query) || str_contains(strtolower($item['descricao']), $query);
        });
        return response()->json(array_values($results));
    }

    /**
     * Busca por medicamentos usando uma lista interna para desenvolvimento.
     */
    public function searchMedicamentos(Request $request)
    {
        $query = strtolower($request->input('q', ''));
        if (strlen($query) < 3) { return response()->json([]); }
        $localMedicamentosList = [
            ['id' => 1, 'nomeProduto' => 'Dipirona Sódica 500mg', 'empresa' => 'Medley'],
            ['id' => 2, 'nomeProduto' => 'Paracetamol 750mg', 'empresa' => 'EMS'],
        ];
        $results = array_filter($localMedicamentosList, function ($item) use ($query) {
            return str_contains(strtolower($item['nomeProduto']), $query);
        });
        return response()->json(array_values($results));
    }

    /**
     * Busca por médicos cadastrados na plataforma.
     */
    public function searchMedicos(Request $request)
    {
        try {
            $query = $request->input('q');

            if (strlen($query) < 3) {
                return response()->json([]);
            }

            // Busca apenas médicos que tenham um perfil associado, para evitar erros
            $medicos = User::where('tipo', 'medico')
                           ->whereHas('medicoProfile') // Garante que o médico tem perfil
                           ->where('name', 'LIKE', "%{$query}%")
                           ->with('medicoProfile') // Carrega o perfil para mostrar o CRM
                           ->limit(10)
                           ->get();

            return response()->json($medicos);

        } catch (\Exception $e) {
            // Se qualquer erro acontecer, regista no log e retorna uma lista vazia
            Log::error('Erro ao buscar médicos: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }
}
