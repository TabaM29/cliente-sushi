<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ClienteAuthController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PedidosController;

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

// Rutas de autenticación de clientes (Públicas)
Route::get('/login', [ClienteAuthController::class, 'showLoginForm'])->name('login.cliente');
Route::post('/login', [ClienteAuthController::class, 'login'])->name('login.cliente.post');
Route::get('/register', [ClienteAuthController::class, 'showRegisterForm'])->name('registro.cliente');
Route::post('/register', [ClienteAuthController::class, 'register'])->name('registro.cliente.post');

// RUTAS PROTEGIDAS (Solo si el cliente tiene sesión/token activo)
Route::middleware(['check.token'])->group(function () {

    Route::post('/logout', [ClienteAuthController::class, 'logout'])->name('logout.cliente');

    // RUTAS DE PERFIL DE CLIENTE 
    Route::prefix('perfil')->group(function () {
        Route::get('/', [PerfilController::class, 'index'])->name('perfil.index');
        Route::put('/datos', [PerfilController::class, 'updateDatos'])->name('perfil.updateDatos');
        Route::post('/foto', [PerfilController::class, 'updateFoto'])->name('perfil.updateFoto');
        Route::put('/password', [PerfilController::class, 'updatePassword'])->name('perfil.updatePassword');
    });

    //Rutas de pedidos
Route::middleware(['check.token'])->group(function () {
    Route::prefix('pedidos')->group(function () {
        Route::get('/', [PedidosController::class, 'index'])->name('pedidos.index');
        
        Route::get('/ver/{id}', [PedidosController::class, 'show'])->name('pedidos.show');
        
        Route::delete('/{id}', [PedidosController::class, 'destroy'])->name('pedidos.destroy');
        
        Route::get('/{id}/pagar', [PedidosController::class, 'pagar'])->name('pedidos.pagar');
        
        Route::get('/confirmar-pago/{pedidoId}/{transaccionId}', [PedidosController::class, 'confirmarPago'])->name('pedidos.confirmarPago');
        
        // Flujo de compra
        Route::get('/checkout', [PedidosController::class, 'checkout'])->name('pedidos.checkout');
        Route::post('/confirmar', [PedidosController::class, 'store'])->name('pedidos.store');
        Route::get('/exito', [PedidosController::class, 'exito'])->name('pedidos.exito');
    });
});
});
