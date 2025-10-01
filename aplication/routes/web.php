<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\TipoProjetoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\BzeroController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/', [BzeroController::class, 'index'])->name('home');
    // Projetos
    Route::resource('/projeto', ProjetoController::class);
    // Bzero
    Route::resource('/bzero', BzeroController::class);
    Route::post('/bzerofiltro', [BzeroController::class, 'filtro'])->name('bzero.filtro');
    Route::post('/preferencia', [BzeroController::class, 'modify'])->name('preferencia.modify');
    // Status
    Route::resource('/status', StatusController::class);
    // User
    Route::resource('user', UserController::class);
    // Tipo Projeto
    Route::resource('/tipoprojeto', TipoProjetoController::class);
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
