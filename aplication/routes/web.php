<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BzeroController;
use App\Http\Controllers\ProjetoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TipoProjetoController;
use App\Http\Controllers\PlataformaController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SubitemController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\User;

Route::middleware('auth')->group(function () {
    // Home
    Route::get('/', [BzeroController::class, 'index'])->name('home');
    // Bzero
    Route::resource('bzero', BzeroController::class);
    Route::post('/bzerofiltro', [BzeroController::class, 'filtro'])->name('bzero.filtro');
    Route::post('/preferencia', [BzeroController::class, 'modify'])->name('preferencia.modify');
    // Projetos
    Route::resource('projeto', ProjetoController::class);
    // Tipo Projeto
    Route::resource('tipoprojeto', TipoProjetoController::class);
    // Plataforma
    Route::resource('plataforma', PlataformaController::class);
    // Item
    Route::resource('item', ItemController::class);
    // Subitens
    Route::resource('subitem', SubitemController::class);
    Route::post('/subitens/associaveis', [SubitemController::class, 'subitensAssociaveis'])->name('subitem.subitensAssociaveis');
    // Status
    Route::resource('status', StatusController::class);
    // User
    Route::resource('usuarios', UserController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
