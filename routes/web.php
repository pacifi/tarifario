<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\TramiteIndex;
use App\Livewire\DepartamentoIndex;
use App\Livewire\NivelAcademicoIndex;
use App\Livewire\TarifaIndex;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tramites', TramiteIndex::class)->name('tramites.index');
    Route::get('/departamentos', DepartamentoIndex::class)->name('departamentos.index');
    Route::get('/niveles-academicos', NivelAcademicoIndex::class)->name('niveles.index');
    Route::get('/tarifas', TarifaIndex::class)->name('tarifas.index');


});

require __DIR__.'/auth.php';
