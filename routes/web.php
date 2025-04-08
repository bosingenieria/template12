<?php

use App\Http\Controllers\Modulos\ClientesController;
use App\Http\Controllers\Modulos\EmpleadosController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\Modulos\RoleController;
use App\Http\Controllers\Modulos\UsuariosController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('empleados', EmpleadosController::class);
    Route::resource('usuarios', UsuariosController::class);
    Route::resource('clientes', ClientesController::class);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
