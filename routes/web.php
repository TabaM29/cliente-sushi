<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CarritoController;

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

// Carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito/add', [CarritoController::class, 'add'])->name('carrito.add');
Route::patch('/carrito/update', [CarritoController::class, 'update'])->name('carrito.update');
Route::delete('/carrito/remove', [CarritoController::class, 'remove'])->name('carrito.remove');
Route::get('/carrito/clear', [CarritoController::class, 'clear'])->name('carrito.clear');