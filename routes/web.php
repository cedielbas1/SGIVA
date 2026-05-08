<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

/*
| Autenticación Laravel (laravel/ui, guard "web", sesión):
| GET/POST login  → LoginController (trait AuthenticatesUsers)
| GET/POST register → RegisterController (trait RegistersUsers; crea usuario e inicia sesión)
| POST logout → LoginController@logout
*/
Auth::routes();

Route::redirect('/home', '/dashboard');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
