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
    Route::get('empleados/tickets', [App\Http\Controllers\TicketController::class, 'empleadosTickets'])->name('empleados/tickets');
    Route::get('/clientes', [App\Http\Controllers\UserController::class, 'clientes'])->name('clientes');
    Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'tickets'])->name('tickets');
    Route::get('/tickets/show/{id}', [App\Http\Controllers\TicketController::class, 'showTicket'])->name('showTicket');
    Route::get('seleccionar_tickets', [App\Http\Controllers\TicketController::class, 'seleccionar_tickets'])->name('seleccionar_tickets');

    Route::get('/tickets/clientes', [App\Http\Controllers\TicketController::class, 'ticketsClientes'])->name('tickets/clientes');
    Route::get('/tickets/add', [App\Http\Controllers\TicketController::class, 'ticketsClientesAddTicket'])->name('tickets/add');
    Route::post('/tickets/add', [App\Http\Controllers\TicketController::class, 'ticketsClientesAddTicketPost'])->name('tickets/add/post');

    /* Rutas para acciones */
    Route::get('/empleados/deshabilitar/{id}', [App\Http\Controllers\UserController::class, 'deshabilitar_empleado'])->name('empleados.deshabilitar');
    Route::get('/empleados/habilitar/{id}', [App\Http\Controllers\UserController::class, 'habilitar_empleado'])->name('empleados.habilitar');
    Route::post('empleados/asignar/ticket', [App\Http\Controllers\UserController::class, 'empleado_asignar_tickets'])->name('empleados/asignar/ticket');
    Route::get('/tickets/{id}/iniciar', [App\Http\Controllers\TicketController::class, 'iniciarTicket'])->name('iniciarTicket');
    Route::get('/tickets/{id}/terminar', [App\Http\Controllers\TicketController::class, 'terminarTicket'])->name('terminarTicket');
    Route::post('/tickets/calificar', [App\Http\Controllers\TicketController::class, 'calificarTicket'])->name('calificarTicket');
});
