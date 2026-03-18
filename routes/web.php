<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ContactoController;

// Inicio
Route::get('/', function () {
    return view('Inicio.inicio');
})->name('inicio');

// Nosotros
Route::get('/nosotros', function () {
    return view('Nosotros.nosotros');
})->name('nosotros');

// Catálogo
Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo');
Route::get('/detalle/{id}', [CatalogoController::class, 'show'])->name('detalle');

// Contacto (Solo Formulario y Envío)
Route::get('/contacto', [ContactoController::class, 'index'])->name('contacto.index');
Route::post('/contacto', [ContactoController::class, 'store'])->name('contacto.store');