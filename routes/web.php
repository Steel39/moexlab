<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UI\Admin\Shares\Command\DeleteSharesFromLocalRepository;
use App\Http\Controllers\UI\Admin\Shares\Command\SaveSharesFromApi;
use App\Http\Controllers\UI\Admin\Shares\GetSharesBoard;
use App\Http\Controllers\UI\User\MOEX\Trades\SharesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/test', TestController::class);
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
Route::get('/terminal/shares', SharesController::class)->name('getTradesOnSharesPerDay');

Route::middleware('auth')->prefix('/admin')->group( function() {
    Route::prefix('/shares')->group( function() {
        Route::get('/', GetSharesBoard::class )->name('shares.board');
        Route::delete('/', DeleteSharesFromLocalRepository::class)->name('shares.delete');
        Route::get('/load', SaveSharesFromApi::class)->name('shares.load');
    });
});

require __DIR__.'/auth.php';


