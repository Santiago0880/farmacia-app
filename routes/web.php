<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

// Autenticación
Auth::routes();

// Ruta principal
Route::get('/', function () {
    return view('auth.login');
});

// Dashboard usando DashboardController
Route::get('/home', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// CRUDs
Route::middleware(['auth'])->group(function () {
    Route::resource('clientes', ClienteController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('productos', InventarioController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('compras', CompraController::class);
    Route::get('/roles', function () { return view('roles.index'); });
});