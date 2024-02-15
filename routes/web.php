<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/clientes', function () {
        return view('clientes');
    })->name('clientes');

    /* Rutas para vistas */
    Route::get('/empleados', [App\Http\Controllers\UserController::class, 'empleados'])->name('empleados');
    Route::get('/clientes', [App\Http\Controllers\UserController::class, 'clientes'])->name('clientes');
    Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'tickets'])->name('tickets');


    Route::get('/tickets/clientes', [App\Http\Controllers\TicketController::class, 'ticketsClientes'])->name('tickets/clientes');
    Route::get('/tickets/add', [App\Http\Controllers\TicketController::class, 'ticketsClientesAddTicket'])->name('tickets/add');
    Route::post('/tickets/add', [App\Http\Controllers\TicketController::class, 'ticketsClientesAddTicketPost'])->name('tickets/add/post');

    /* Rutas para acciones */
    Route::get('/empleados/deshabilitar/{id}', [App\Http\Controllers\UserController::class, 'deshabilitar_empleado'])->name('empleados.deshabilitar');
    Route::get('/empleados/habilitar/{id}', [App\Http\Controllers\UserController::class, 'habilitar_empleado'])->name('empleados.habilitar');
});
