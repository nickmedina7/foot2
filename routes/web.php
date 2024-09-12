<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Auth;
use App\Models\Detail;

Route::get('/', function () {
    return redirect('home');
});

// Rutas de autenticación
Auth::routes();

// Ruta de inicio
Route::get('/home', [HomeController::class, 'index']);

// Agrupación de rutas que requieren autenticación
Route::group(['middleware' => 'auth'], function () {

    // Rutas de usuarios
    Route::resource('users', UserController::class);
    Route::put('users.update_foto/{id}',  [UserController::class, 'updateFoto'])->name('users.update_foto');
    Route::put('users.update_password/{id}',  [UserController::class, 'updatePassword'])->name('users.update_password');

    // Rutas de productos
    Route::resource('products', ProductController::class);
    Route::get('product_list', [ProductController::class, 'product_list']);

    // Rutas de clientes
    Route::resource('clients', ClientController::class, ['except' => 'show']);
    Route::get('clients_list/{nit}', [ClientController::class, 'clients_list']);

    // Rutas de ventas
    Route::resource('sales', SaleController::class, ['except' => ['edit', 'update']]);
    Route::delete('sale_delete/{id}', [SaleController::class, 'sale_delete']);

    // Rutas de detalles
    Route::resource('details', DetailController::class, ['only' => 'store']);

    // Rutas de reportes
    Route::get('print_recibo/{id}', [ReporteController::class, 'print_recibo']);
    Route::get('reporte_economico', [ReporteController::class, 'reporte_economico']);
    Route::get('reporte_estadistico', [ReporteController::class, 'reporte_estadistico']);

});

// Ruta de prueba para obtener todos los detalles
Route::get('prueba', function () {
    return Detail::all();
});
