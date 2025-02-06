<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function(){
    return('hello');
});
Route::get('/home', function () {
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


//google auth

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');

Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');


//sending Mail
Route::get('/confirm/{token}', [AuthController::class, 'confirmRegister'])->name('confirm.register');






