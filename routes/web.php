<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Medico\DashboardController as MedicoDashboardController;
use App\Http\Controllers\Medico\PrescricaoController;
use App\Http\Controllers\Paciente\DashboardController as PacienteDashboardController;
use App\Http\Controllers\Paciente\PrescricaoController as PacientePrescricaoController;
use App\Http\Controllers\PrescricaoPublicController;

Route::get('/', function () {
    return view('welcome');
});

// ROTA PÚBLICA DE VALIDAÇÃO
Route::get('/validar/{hash}', [PrescricaoPublicController::class, 'show'])->name('prescricao.validar.show');

// Rota de dashboard principal, agora apontando para o PacienteDashboardController
Route::get('/dashboard', [PacienteDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de perfil (inalterado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Grupo de Rotas do Médico (inalterado)
Route::middleware(['auth', 'is.medico'])->prefix('medico')->name('medico.')->group(function () {

    Route::get('/dashboard', [MedicoDashboardController::class, 'index'])->name('dashboard');
    Route::get('/prescricoes/nova', [PrescricaoController::class, 'create'])->name('prescricoes.create');
    Route::post('/prescricoes', [PrescricaoController::class, 'store'])->name('prescricoes.store');
    Route::get('/prescricoes/{prescricao}', [PrescricaoController::class, 'show'])->name('prescricoes.show');
    Route::get('/prescricoes/{prescricao}/pdf', [PrescricaoController::class, 'gerarPdf'])->name('prescricoes.pdf');
});

// Grupo de Rotas do Paciente
Route::middleware(['auth', 'is.paciente'])->prefix('paciente')->name('paciente.')->group(function () {
    // A rota /dashboard agora aponta para o controller de paciente
    Route::get('/dashboard', [PacienteDashboardController::class, 'index'])->name('dashboard');

    // Nova rota para o paciente visualizar a prescrição
    Route::get('/prescricoes/{prescricao}', [PacientePrescricaoController::class, 'show'])->name('prescricoes.show');
});

require __DIR__.'/auth.php';