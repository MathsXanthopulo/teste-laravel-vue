<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rotas de autenticação
require __DIR__.'/auth.php';

// Rota principal - Dashboard
Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas por autenticação
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');
    
    // Colaboradores
    Route::get('/colaboradores', [App\Http\Controllers\ColaboradoresController::class, 'index'])->name('colaboradores.index');
    Route::post('/colaboradores', [App\Http\Controllers\ColaboradoresController::class, 'store'])->name('colaboradores.store');
    Route::put('/colaboradores/{id}', [App\Http\Controllers\ColaboradoresController::class, 'update'])->name('colaboradores.update');
    Route::delete('/colaboradores/{id}', [App\Http\Controllers\ColaboradoresController::class, 'destroy'])->name('colaboradores.destroy');
    
});

