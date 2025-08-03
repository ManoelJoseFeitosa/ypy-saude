<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Medico\DashboardController as MedicoDashboardController;
use App\Http\Controllers\Medico\PrescricaoController;
use App\Http\Controllers\Paciente\DashboardController as PacienteDashboardController;
use App\Http\Controllers\Paciente\PrescricaoController as PacientePrescricaoController;
use App\Http\Controllers\Medico\AtestadoController;
use App\Http\Controllers\Paciente\AtestadoController as PacienteAtestadoController;
use App\Http\Controllers\ApiProxyController;
use App\Http\Controllers\Medico\PacienteController;
use App\Http\Controllers\Medico\LaudoController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Páginas do Site)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingPageController::class, 'home'])->name('home');
Route::get('/contato', [LandingPageController::class, 'contato'])->name('contato');
Route::get('/planos', [LandingPageController::class, 'planos'])->name('planos');

// ROTAS DE VALIDAÇÃO UNIFICADAS
Route::get('/validar/prescricao/{hash}', [ValidacaoController::class, 'show'])->setDefaults(['tipo' => 'prescricao'])->name('prescricao.validar.show');
Route::get('/validar/atestado/{hash}', [ValidacaoController::class, 'show'])->setDefaults(['tipo' => 'atestado'])->name('atestado.validar.show');
Route::get('/validar/laudo/{hash}', [ValidacaoController::class, 'show'])->setDefaults(['tipo' => 'laudo'])->name('laudo.validar.show');

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação e Dashboards
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->tipo === 'medico') {
        return redirect()->route('medico.dashboard');
    }
    return redirect()->route('paciente.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas do Médico
Route::middleware(['auth', 'is.medico'])->prefix('medico')->name('medico.')->group(function () {
    Route::get('/dashboard', [MedicoDashboardController::class, 'index'])->name('dashboard');
    Route::get('/prescricoes/nova', [PrescricaoController::class, 'create'])->name('prescricoes.create');
    Route::post('/prescricoes', [PrescricaoController::class, 'store'])->name('prescricoes.store');
    Route::get('/prescricoes/{prescricao}', [PrescricaoController::class, 'show'])->name('prescricoes.show');
    Route::get('/prescricoes/{prescricao}/pdf', [PrescricaoController::class, 'gerarPdf'])->name('prescricoes.pdf');
    Route::get('/atestados/novo', [AtestadoController::class, 'create'])->name('atestados.create');
    Route::post('/atestados', [AtestadoController::class, 'store'])->name('atestados.store');
    Route::get('/atestados/{atestado}/pdf', [AtestadoController::class, 'gerarPdf'])->name('atestados.pdf');
    Route::get('/api/cid-search', [ApiProxyController::class, 'searchCid'])->name('api.cid.search');
    Route::get('/api/medicamentos-search', [ApiProxyController::class, 'searchMedicamentos'])->name('api.medicamentos.search');
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show');    
    Route::post('/pacientes/{paciente}/prontuario', [PacienteController::class, 'storeProntuario'])->name('pacientes.prontuario.store');
    Route::get('/laudos/novo', [LaudoController::class, 'create'])->name('laudos.create');
    Route::post('/laudos', [LaudoController::class, 'store'])->name('laudos.store');
    Route::get('/laudos/{laudo}/pdf', [LaudoController::class, 'gerarPdf'])->name('laudos.pdf');
});

// Rotas do Paciente
Route::middleware(['auth', 'is.paciente'])->prefix('paciente')->name('paciente.')->group(function () {
    Route::get('/dashboard', [PacienteDashboardController::class, 'index'])->name('dashboard');
    Route::get('/prescricoes/{prescricao}', [PacientePrescricaoController::class, 'show'])->name('prescricoes.show');
    Route::get('/atestados/{atestado}/pdf', [PacienteAtestadoController::class, 'gerarPdf'])->name('atestados.pdf');
    Route::get('/laudos/{laudo}/pdf', [PacienteLaudoController::class, 'gerarPdf'])->name('laudos.pdf');
});

// Rota Pública de Validação
Route::get('/validar/{hash}', [App\Http\Controllers\PrescricaoPublicController::class, 'show'])->name('prescricao.validar.show');


// Rotas de Perfil do Usuário
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
