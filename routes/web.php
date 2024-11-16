<?php

use App\Http\Controllers\Customer\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\RoleMiddleware;

Route::aliasMiddleware('role', RoleMiddleware::class);

Route::prefix('auth')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login')->middleware('guest');
    Route::post('login', [AuthController::class, 'authentication'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'postRegis'])->name('register.post');
    Route::POST('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('c.home');
});


Route::fallback(function () {
    return redirect()->route('c.home');
});




