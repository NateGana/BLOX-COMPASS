<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\FruitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TradingController;
use App\Http\Controllers\WflController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:10,1');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/fruits', [FruitController::class, 'index'])->name('fruits.index');
Route::get('/fruits/{fruit}', [FruitController::class, 'show'])->name('fruits.show');

Route::get('/trading', [TradingController::class, 'index'])->name('trading.index');
Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');
Route::post('/calculator/evaluate', [CalculatorController::class, 'evaluate'])->name('calculator.evaluate');
Route::get('/wfl', [WflController::class, 'index'])->name('wfl.index');

Route::middleware('auth')->group(function () {
    Route::post('/fruits/{fruit}/suggest', [FruitController::class, 'suggest'])->name('fruits.suggest');
    Route::get('/trading/create', [TradingController::class, 'create'])->name('trading.create');
    Route::post('/trading', [TradingController::class, 'store'])->name('trading.store');
    Route::patch('/trading/{post}/close', [TradingController::class, 'close'])->name('trading.close');
    Route::delete('/trading/{post}', [TradingController::class, 'destroy'])->name('trading.destroy');
    Route::get('/wfl/create', [WflController::class, 'create'])->name('wfl.create');
    Route::post('/wfl', [WflController::class, 'store'])->name('wfl.store');
    Route::post('/wfl/{post}/vote', [WflController::class, 'vote'])->name('wfl.vote')->middleware('throttle:30,1');
});

Route::get('/wfl/{post}', [WflController::class, 'show'])->name('wfl.show');
