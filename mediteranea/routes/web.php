<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
Route::get('/', function () {
    return view('welcome');
})->middleware('auth')->name('home');


Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('store.register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'login'])->name('store.login');

Route::get('/logout', [AuthController::class, 'invoke'])
    ->middleware(['auth', 'auth.session'])->name('logout');

Route::post('/forgot-password', [AuthController::class, 'storeLinkForgotPassword']);
Route::post('/forgot-password/{token}', [AuthController::class, 'resetForgotPassword']);






