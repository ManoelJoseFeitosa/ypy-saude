<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingPageController; // Importa o novo controller
use App\Http\Controllers\Medico\DashboardController as MedicoDashboardController;
use App\Http\Controllers\Medico\PrescricaoController;
use App\Http\Controllers\Paciente\DashboardController as PacienteDashboardController;
use App\Http\Controllers\Paciente\PrescricaoController as PacientePrescricaoController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas (Páginas do Site)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingPageController::class, 'home'])->name('home');
Route::get('/contato', [LandingPageController::class, 'contato'])->name('contato');
Route::get('/planos', [LandingPageController::class, 'planos'])->name('planos');


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
});

// Rotas do Paciente
Route::middleware(['auth', 'is.paciente'])->prefix('paciente')->name('paciente.')->group(function () {
    Route::get('/dashboard', [PacienteDashboardController::class, 'index'])->name('dashboard');
    Route::get('/prescricoes/{prescricao}', [PacientePrescricaoController::class, 'show'])->name('prescricoes.show');
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