<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ClienteDespachoController;
use Illuminate\Support\Facades\Route;

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

    Route::resource('ventas', VentaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('users', UserController::class);
    Route::resource('clientes_despacho', ClienteDespachoController::class);

    Route::get('/producto/buscar', [ProductoController::class, 'buscar'])->name('productos.buscar');
    Route::post('/venta/guardar', [VentaController::class, 'store'])->name('venta.guardar');


    Route::get('/reporteproductos', [ReporteController::class, 'productos'])->name('reporteproductos');
    Route::get('/reporteusuarios', [ReporteController::class, 'usuarios'])->name('reporteusuarios');
});

require __DIR__.'/auth.php';
