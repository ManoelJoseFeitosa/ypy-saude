<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Medico\DashboardController as MedicoDashboardController;
use App\Http\Controllers\Medico\PrescricaoController;

Route::get('/', function () {
    return view('welcome');
});

// Rota de dashboard principal (agora inteligente)
Route::get('/dashboard', function () {
    if (auth()->user()->tipo === 'medico') {
        return redirect()->route('medico.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas de perfil (inalterado)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// NOVO: Grupo de Rotas do Médico
// Este grupo só é acessível por usuários autenticados E que são médicos.
Route::middleware(['auth', 'is.medico'])->prefix('medico')->name('medico.')->group(function () {

    Route::get('/dashboard', [MedicoDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/prescricoes/nova', [PrescricaoController::class, 'create'])->name('prescricoes.create');
    Route::post('/prescricoes', [PrescricaoController::class, 'store'])->name('prescricoes.store');
    Route::get('/prescricoes/{prescricao}', [PrescricaoController::class, 'show'])->name('prescricoes.show');
});

require __DIR__.'/auth.php';