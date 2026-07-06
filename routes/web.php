<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\HealthCheckController;

Route::get('/', function () {
    return view('welcome');
});

/*
| Health Check Endpoints (no auth requerido para monitoreo externo)
*/
Route::get('/health', [HealthCheckController::class, 'check']);
Route::get('/health/detailed', [HealthCheckController::class, 'detailed'])->middleware('auth');

/*
| Autenticación Laravel (laravel/ui, guard "web", sesión):
| GET/POST login  → LoginController (trait AuthenticatesUsers)
| GET/POST register → RegisterController (trait RegistersUsers; crea usuario e inicia sesión)
| POST logout → LoginController@logout
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::get('/mi-cuenta', [ProfileController::class, 'edit'])->name('account.edit');
    Route::put('/mi-cuenta', [ProfileController::class, 'update'])->name('account.update');
    Route::put('/mi-cuenta/password', [ProfileController::class, 'updatePassword'])->name('account.password');
});

Route::redirect('/home', '/dashboard');
// Rutas de modificación - solo admin
Route::middleware(['auth', 'check_role:admin'])->group(function () {
    Route::get('/cultivos/create', [CultivoController::class, 'create'])->name('cultivos.create');
    Route::post('/cultivos', [CultivoController::class, 'store'])->name('cultivos.store');
    Route::get('/cultivos/{cultivo}/edit', [CultivoController::class, 'edit'])->name('cultivos.edit');
    Route::put('/cultivos/{cultivo}', [CultivoController::class, 'update'])->name('cultivos.update');
    Route::delete('/cultivos/{cultivo}', [CultivoController::class, 'destroy'])->name('cultivos.destroy');

    Route::get('/lotes/create', [LoteController::class, 'create'])->name('lotes.create');
    Route::post('/lotes', [LoteController::class, 'store'])->name('lotes.store');
    Route::get('/lotes/{lote}/edit', [LoteController::class, 'edit'])->name('lotes.edit');
    Route::put('/lotes/{lote}', [LoteController::class, 'update'])->name('lotes.update');
    Route::delete('/lotes/{lote}', [LoteController::class, 'destroy'])->name('lotes.destroy');

    Route::get('/inventarios/create', [InventarioController::class, 'create'])->name('inventarios.create');
    Route::post('/inventarios', [InventarioController::class, 'store'])->name('inventarios.store');
    Route::get('/inventarios/{inventario}/edit', [InventarioController::class, 'edit'])->name('inventarios.edit');
    Route::put('/inventarios/{inventario}', [InventarioController::class, 'update'])->name('inventarios.update');
    Route::delete('/inventarios/{inventario}', [InventarioController::class, 'destroy'])->name('inventarios.destroy');

    Route::get('/insumos/create', [InsumoController::class, 'create'])->name('insumos.create');
    Route::post('/insumos', [InsumoController::class, 'store'])->name('insumos.store');
    Route::get('/insumos/{insumo}/edit', [InsumoController::class, 'edit'])->name('insumos.edit');
    Route::put('/insumos/{insumo}', [InsumoController::class, 'update'])->name('insumos.update');
    Route::delete('/insumos/{insumo}', [InsumoController::class, 'destroy'])->name('insumos.destroy');

    Route::get('/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}/edit', [VentaController::class, 'edit'])->name('ventas.edit');
    Route::put('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
});

// Actividades - usuarios pueden crear propias, admins pueden editar todas
Route::get('/actividades/create', [ActividadController::class, 'create'])->name('actividades.create')->middleware('auth');
Route::post('/actividades', [ActividadController::class, 'store'])->name('actividades.store')->middleware('auth');
Route::get('/actividades/{actividad}/edit', [ActividadController::class, 'edit'])->name('actividades.edit')->middleware('auth');
Route::put('/actividades/{actividad}', [ActividadController::class, 'update'])->name('actividades.update')->middleware('auth');
Route::delete('/actividades/{actividad}', [ActividadController::class, 'destroy'])->name('actividades.destroy')->middleware('auth');

// Rutas públicas de lectura - solo autenticados
Route::get('/cultivos', [CultivoController::class, 'index'])->name('cultivos.index')->middleware('auth');
Route::get('/cultivos/{cultivo}', [CultivoController::class, 'show'])->name('cultivos.show')->middleware('auth');
Route::get('/lotes', [LoteController::class, 'index'])->name('lotes.index')->middleware('auth');
Route::get('/lotes/{lote}', [LoteController::class, 'show'])->name('lotes.show')->middleware('auth');
Route::get('/inventarios', [InventarioController::class, 'index'])->name('inventarios.index')->middleware('auth');
Route::get('/inventarios/{inventario}', [InventarioController::class, 'show'])->name('inventarios.show')->middleware('auth');
Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index')->middleware('auth');
Route::get('/actividades/{actividad}', [ActividadController::class, 'show'])->name('actividades.show')->middleware('auth');
Route::get('/insumos', [InsumoController::class, 'index'])->name('insumos.index')->middleware('auth');
Route::get('/insumos/{insumo}', [InsumoController::class, 'show'])->name('insumos.show')->middleware('auth');
Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index')->middleware('auth');
Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show')->middleware('auth');