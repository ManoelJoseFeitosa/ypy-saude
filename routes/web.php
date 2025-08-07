<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ValidacaoController;
use App\Http\Controllers\ApiProxyController;
use App\Http\Controllers\Medico\DashboardController as MedicoDashboardController;
use App\Http\Controllers\Medico\PrescricaoController;
use App\Http\Controllers\Medico\AtestadoController;
use App\Http\Controllers\Medico\LaudoController;
use App\Http\Controllers\Medico\PacienteController;
use App\Http\Controllers\Medico\HorarioController;
use App\Http\Controllers\Paciente\DashboardController as PacienteDashboardController;
use App\Http\Controllers\Paciente\DocumentoController;
use App\Http\Controllers\Paciente\AgendamentoController;
use App\Http\Controllers\EHRTestController;
use App\Http\Controllers\MercadoPagoController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Acessíveis a todos)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingPageController::class, 'home'])->name('home');
Route::get('/contato', [LandingPageController::class, 'contato'])->name('contato');
Route::get('/planos', [LandingPageController::class, 'planos'])->name('planos');
Route::get('/termos-de-uso', [LandingPageController::class, 'termos'])->name('termos');

// Rotas de Validação
Route::get('/validar/prescricao/{hash}', [ValidacaoController::class, 'show'])->setDefaults(['tipo' => 'prescricao'])->name('prescricao.validar.show');
Route::get('/validar/atestado/{hash}', [ValidacaoController::class, 'show'])->setDefaults(['tipo' => 'atestado'])->name('atestado.validar.show');
Route::get('/validar/laudo/{hash}', [ValidacaoController::class, 'show'])->setDefaults(['tipo' => 'laudo'])->name('laudo.validar.show');

// Rotas de Integração
Route::get('/ehr/paciente/{id}', [EHRTestController::class, 'show'])->name('ehr.paciente.show');


/*
|--------------------------------------------------------------------------
| Rotas de Pagamentos e Assinaturas (Mercado Pago)
|--------------------------------------------------------------------------
*/
Route::get('/subscribe/checkout/{user}', [MercadoPagoController::class, 'checkout'])->name('mercadopago.checkout');
Route::get('/subscribe/success', [MercadoPagoController::class, 'success'])->name('subscribe.success');
Route::get('/subscribe/failure', [MercadoPagoController::class, 'failure'])->name('subscribe.failure');


/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Exigem Login e Verificação de Email)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rota principal do Dashboard (redireciona para o painel correto)
    Route::get('/dashboard', function () {
        if (auth()->user()->tipo === 'medico') {
            return redirect()->route('medico.dashboard');
        }
        return redirect()->route('paciente.dashboard');
    })->name('dashboard');

    // Rotas do Médico
    Route::middleware('can:is-medico')->prefix('medico')->name('medico.')->group(function () {
        Route::get('/dashboard', [MedicoDashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/prescricoes/nova', [PrescricaoController::class, 'create'])->name('prescricoes.create');
        Route::post('/prescricoes', [PrescricaoController::class, 'store'])->name('prescricoes.store');
        Route::get('/prescricoes/{prescricao}', [PrescricaoController::class, 'show'])->name('prescricoes.show');
        Route::get('/prescricoes/{prescricao}/pdf', [PrescricaoController::class, 'gerarPdf'])->name('prescricoes.pdf');

        Route::get('/atestados/novo', [AtestadoController::class, 'create'])->name('atestados.create');
        Route::post('/atestados', [AtestadoController::class, 'store'])->name('atestados.store');
        Route::get('/atestados/{atestado}/pdf', [AtestadoController::class, 'gerarPdf'])->name('atestados.pdf');

        Route::get('/laudos/novo', [LaudoController::class, 'create'])->name('laudos.create');
        Route::post('/laudos', [LaudoController::class, 'store'])->name('laudos.store');
        Route::get('/laudos/{laudo}/pdf', [LaudoController::class, 'gerarPdf'])->name('laudos.pdf');

        Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
        Route::get('/pacientes/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show');
        Route::post('/pacientes/{paciente}/prontuario', [PacienteController::class, 'storeProntuario'])->name('pacientes.prontuario.store');

        Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
        Route::post('/horarios', [HorarioController::class, 'store'])->name('horarios.store');
        Route::delete('/horarios/{horario}', [HorarioController::class, 'destroy'])->name('horarios.destroy');
    });

    // Rotas do Paciente
    Route::middleware('can:is-paciente')->prefix('paciente')->name('paciente.')->group(function () {
        Route::get('/dashboard', [PacienteDashboardController::class, 'index'])->name('dashboard');
        Route::get('/documentos/{tipo}/{id}', [DocumentoController::class, 'show'])->name('documentos.show');
    });

    // Rotas para Agendamento pelo Paciente
    Route::middleware('can:is-paciente')->prefix('agendamento')->name('agendamento.')->group(function () {
        Route::get('/', [AgendamentoController::class, 'index'])->name('index');
        Route::get('/medico/{medico}', [AgendamentoController::class, 'show'])->name('show');
        Route::get('/medico/{medico}/horarios', [AgendamentoController::class, 'fetchHorarios'])->name('fetchHorarios');
        Route::post('/medico/{medico}', [AgendamentoController::class, 'store'])->name('store');
    });

    // Rotas de Perfil do Usuário (agora dentro do mesmo grupo)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota para testar a conexão com a API da ZapSign
Route::get('/test-zapsign', [App\Http\Controllers\ZapSignController::class, 'testConnection']);

// Rota para testar a conexão direta com a API da ZapSign, ignorando a configuração do Laravel
Route::get('/direct-test-zapsign', function () {
    // Colamos o token diretamente aqui para o teste
    $apiToken = '2478e1e9-4350-4a27-9087-27773b194eaac3d71ab6-3be1-4139-b0e3-bf0a73c44f42';
    $apiUrl = 'https://api.zapsign.com.br/api/v1';

    echo "<h1>Teste Direto de Conexão com ZapSign</h1>";
    echo "<p>Tentando conectar com o token...</p><hr>";

    try {
        // Usamos o cliente HTTP do Laravel para fazer a chamada
        $response = Illuminate\Support\Facades\Http::withQueryParameters(['api_token' => $apiToken])
            ->timeout(15) // Aumenta o tempo limite para 15 segundos
            ->get("{$apiUrl}/organizations/");

        if ($response->successful()) {
            echo "<h2 style='color:green;'>SUCESSO!</h2>";
            echo "<p>A conexão com a API da ZapSign foi bem-sucedida.</p>";
            echo "<h3>Dados recebidos:</h3>";
            echo "<pre>";
            print_r($response->json());
            echo "</pre>";
        } else {
            echo "<h2 style='color:red;'>FALHA NA RESPOSTA DA API!</h2>";
            echo "<p>A conexão foi estabelecida, mas a API da ZapSign retornou um erro.</p>";
            echo "<p>Código do Erro: " . $response->status() . "</p>";
            echo "<h3>Resposta da API:</h3>";
            echo "<pre>";
            print_r($response->json());
            echo "</pre>";
        }
    } catch (\Exception $e) {
        echo "<h2 style='color:red;'>FALHA GERAL DE CONEXÃO!</h2>";
        echo "<p>Não foi possível conectar ao servidor da ZapSign. Isto geralmente indica um problema de firewall ou de cURL no servidor da Hostinger.</p>";
        echo "<h3>Mensagem de Erro Detalhada:</h3>";
        echo "<pre>" . $e->getMessage() . "</pre>";
    }
});

// Rotas de autenticação (login, registro, etc.)
require __DIR__.'/auth.php';
