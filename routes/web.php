<?php

use Illuminate\Support\Facades\Route;

//Middleware
use App\Http\Middleware\RoleMiddleware;

//Controller
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\Customer\TransactionController;

//Alias Middleware
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
    Route::prefix('transactions')->group(function () {
        Route::get('buy', [TransactionController::class, 'indexBuy'])->name('c.transactions.buy');
        Route::get('sell', [TransactionController::class, 'indexSell'])->name('c.transactions.sell');
        Route::get('form', [TransactionController::class, 'create'])->name('c.transactions.form');
        Route::get('map', [TransactionController::class, 'map'])->name('c.transactions.map');
    });
});


Route::fallback(function () {
    return redirect()->route('c.home');
});




