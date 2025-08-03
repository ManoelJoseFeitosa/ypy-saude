<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Já não precisamos de Http ou Log para a versão local
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

class ApiProxyController extends Controller
{
    /**
     * Busca por códigos CID usando uma lista interna para desenvolvimento.
     */
    public function searchCid(Request $request)
    {
        $query = strtolower($request->input('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Lista de CIDs interna para contornar problemas de rede local
        $localCidList = [
            ['codigo' => 'A09', 'descricao' => 'Diarreia e gastroenterite de origem infecciosa presumível'],
            ['codigo' => 'J00', 'descricao' => 'Nasofaringite aguda (resfriado comum)'],
            ['codigo' => 'J02.9', 'descricao' => 'Faringite aguda não especificada'],
            ['codigo' => 'J06.9', 'descricao' => 'Infecção aguda das vias aéreas superiores não especificada'],
            ['codigo' => 'J11', 'descricao' => 'Influenza (gripe) com vírus não identificado'],
            ['codigo' => 'R51', 'descricao' => 'Cefaleia (dor de cabeça)'],
            ['codigo' => 'M54.5', 'descricao' => 'Dor lombar baixa'],
            ['codigo' => 'K29.7', 'descricao' => 'Gastrite não especificada'],
            ['codigo' => 'L23.9', 'descricao' => 'Dermatite de contato alérgica de causa não especificada'],
            ['codigo' => 'N39.0', 'descricao' => 'Infecção do trato urinário de localização não especificada'],
        ];

        $results = array_filter($localCidList, function ($item) use ($query) {
            // Busca tanto no código quanto na descrição
            return str_contains(strtolower($item['codigo']), $query) || str_contains(strtolower($item['descricao']), $query);
        });

        // Reindexa o array para garantir que seja um JSON de array válido
        return response()->json(array_values($results));
    }

    /**
     * Busca por medicamentos usando uma lista interna para desenvolvimento.
     */
    public function searchMedicamentos(Request $request)
    {
        $query = strtolower($request->input('q', ''));

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        // Lista de Medicamentos interna para contornar problemas de rede local
        $localMedicamentosList = [
            ['id' => 1, 'nomeProduto' => 'Dipirona Sódica 500mg', 'empresa' => 'Medley'],
            ['id' => 2, 'nomeProduto' => 'Paracetamol 750mg', 'empresa' => 'EMS'],
            ['id' => 3, 'nomeProduto' => 'Amoxicilina 500mg', 'empresa' => 'Neo Química'],
            ['id' => 4, 'nomeProduto' => 'Ibuprofeno 400mg', 'empresa' => 'Cimed'],
            ['id' => 5, 'nomeProduto' => 'Loratadina 10mg', 'empresa' => 'Aché'],
            ['id' => 6, 'nomeProduto' => 'Omeprazol 20mg', 'empresa' => 'Eurofarma'],
            ['id' => 7, 'nomeProduto' => 'Nimesulida 100mg', 'empresa' => 'Prati-Donaduzzi'],
            ['id' => 8, 'nomeProduto' => 'Losartana Potássica 50mg', 'empresa' => 'Sandoz'],
            ['id' => 9, 'nomeProduto' => 'Sinvastatina 20mg', 'empresa' => 'Germed Pharma'],
            ['id' => 10, 'nomeProduto' => 'Cloridrato de Metformina 850mg', 'empresa' => 'Sanofi'],
        ];

        $results = array_filter($localMedicamentosList, function ($item) use ($query) {
            // Busca no nome do produto
            return str_contains(strtolower($item['nomeProduto']), $query);
        });

        // Reindexa o array para garantir que seja um JSON de array válido
        return response()->json(array_values($results));
    }
}
