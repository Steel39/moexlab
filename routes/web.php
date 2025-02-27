<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UI\User\MOEX\Trades\SharesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', \App\Http\Controllers\UI\User\WelcomeController::class)->name('welcome');
Route::get('/terminal', \App\Http\Controllers\UI\User\MOEX\Terminal\TradeTerminalController::class)->name('terminal');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('api/getTradesOnSharesPerDay', [SharesController::class, 'getData'])->name('getTradesOnSharesPerDay');

require __DIR__.'/auth.php';
