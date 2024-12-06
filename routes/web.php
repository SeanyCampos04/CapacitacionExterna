<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroCapacitacionesExtController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ConstanciaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\UsuarioController;

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
    return view('auth.login');
});

Route::middleware(['auth', 'role:admin,CAD,Jefe Departamento,Subdirector Academico'])->group(function () {
    Route::get('/capacitaciones', [RegistroCapacitacionesExtController::class, 'index'])->name('datos');

    // Usuarios
    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/datos/{id}', [UsuarioController::class, 'show'])->name('usuario_datos.index');
    // Departamentos
    Route::resource('departamentos', DepartamentoController::class);
    
});

Route::middleware(['auth', 'role:admin,CAD'])->group(function () {
    // Usuarios
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('usuario/editar/{id}', [UsuarioController::class, 'edit'])->name('usuario.edit');
    Route::put('/usuario/{usuario}', [UsuarioController::class, 'update'])->name('user.update');
    Route::put('usuario/{id}/Activar', [UsuarioController::class, 'activar'])->name('usuario.activar');
    Route::put('usuario/{id}/desactivar', [UsuarioController::class, 'desactivar'])->name('usuario.desactivar');


    Route::get('/capacitacionesext/filtrar', [RegistroCapacitacionesExtController::class, 'filtrar'])->name('capacitacionesext.filtrar');
    Route::get('/capacitacionesext/constancia/{id}', [ConstanciaController::class, 'generarPDF'])->name('capacitacionesext.constancia');
    Route::post('/capacitacionesext/{id}/actualizar-status', [RegistroCapacitacionesExtController::class, 'actualizarStatus'])->name('capacitacionesext.actualizarStatus');
    Route::post('/capacitacionesext/{id}/actualizar-folio', [RegistroCapacitacionesExtController::class, 'actualizarFolio'])->name('capacitacionesext.actualizarFolio');
    Route::post('/capacitacionesext/actualizar/{id}', [RegistroCapacitacionesExtController::class, 'actualizarDatos'])->name('capacitacionesext.actualizarDatos');
    Route::delete('/capacitacionesext/{id}', [RegistroCapacitacionesExtController::class, 'destroy'])->name('capacitacionesext.destroy');

    
});

Route::middleware(['auth', 'tipo:1'])->group(function () {
    Route::get('/mis-capacitaciones', [RegistroCapacitacionesExtController::class, 'mis_capacitaciones'])->name('mis_capacitaciones');
    Route::post('/capacitacionesext', [RegistroCapacitacionesExtController::class, 'store'])->name('capacitacionesext.store');
    Route::get('/formulario', function () {
        return view('datos.formulario');
    })->name('formulario');
    Route::delete('/capacitacionesext/{id}', [RegistroCapacitacionesExtController::class, 'destroy'])->name('capacitacionesext.destroy');
});

Route::get('/constancia/{id}', [ConstanciaController::class, 'generarPDF'])->name('constancia.pdf');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', function () {
        return view('datos.dashboard');
    })->name('dashboard');
});

require __DIR__ . '/auth.php';
