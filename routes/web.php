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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('c.home');
    Route::get('history', [HomeController::class, 'history'])->name('c.history');
    Route::get('redeemPoint', [HomeController::class, 'redeemPoint'])->name('c.redeemPoint');
    Route::post('redeemPoint/{uuid}', [HomeController::class, 'buyPromo'])->name('c.buyPromo');
    Route::prefix('transactions')->group(function () {
        Route::get('buy', [TransactionController::class, 'indexBuy'])->name('c.transactions.buy');
        Route::get('sell', [TransactionController::class, 'indexSell'])->name('c.transactions.sell');
        Route::get('{title}/form/{uuid}', [TransactionController::class, 'create'])->name('c.transactions.form');
        Route::post('addAddress', [TransactionController::class, 'addAddress'])->name('c.transactions.addAddress');
        Route::get('addressList', [TransactionController::class, 'addressList'])->name('c.transactions.addressList');
        Route::get('promoList/{type}', [TransactionController::class, 'promoList'])->name('c.transactions.promoList');
        Route::post('store', [TransactionController::class, 'store'])->name('c.transactions.store');
    });
});


Route::fallback(function () {
    return redirect()->route('c.home');
});




