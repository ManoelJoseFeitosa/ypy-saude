<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\ZapSignController;
use App\Http\Controllers\ApiProxyController;
use App\Models\User; // Adicionado para a busca de médicos

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rota padrão do Laravel Sanctum para obter o usuário autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// --- ROTA DO WEBHOOK ADICIONADA ---
// Rota para o Webhook (notificação do servidor do Mercado Pago)
Route::post('/mercadopago/webhook', [MercadoPagoController::class, 'webhook'])->name('mercadopago.webhook');

// Rota para o Webhook da ZapSign
Route::post('/zapsign/webhook', [ZapSignController::class, 'webhook'])->name('zapsign.webhook');

// Rota para a busca de medicamentos na API externa
Route::get('/medicamentos/search', [ApiProxyController::class, 'searchMedicamentos'])->name('api.medicamentos.search');

// --- ROTA CORRIGIDA ---
// Rota para a busca de médicos na página de registro
Route::get('/medicos/search', function (Request $request) {
    
    // Validação para evitar buscas vazias ou muito curtas
    if (!$request->has('q') || strlen($request->q) < 3) {
        return response()->json([]);
    }

    $termoDeBusca = $request->q;

    // Executa a busca no banco de dados
    // ATENÇÃO: Verifique se os nomes das colunas 'tipo', 'name' e 'crm'
    // correspondem exatamente à sua tabela de usuários.
    $medicos = User::where('tipo', 'medico')
                   ->where(function ($query) use ($termoDeBusca) {
                       $query->where('name', 'LIKE', "%{$termoDeBusca}%")
                             ->orWhere('crm', 'LIKE', "%{$termoDeBusca}%");
                   })
                   ->select(['id', 'name', 'crm']) // Retorna apenas os dados necessários
                   ->limit(10) // Limita a 10 resultados para performance
                   ->get();

    return response()->json($medicos);

})->name('api.medicos.search'); // Define o nome da rota que estava faltando
