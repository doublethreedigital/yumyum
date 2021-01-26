<?php

use DoubleThreeDigital\Feeder\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;

Route::prefix('feeder')->name('feeder.')->group(function () {
    Route::prefix('feeds')->name('feeds.')->group(function () {
        Route::get('/', [FeedController::class, 'index'])->name('index');
        Route::get('/create', [FeedController::class, 'create'])->name('create');
        Route::post('/create', [FeedController::class, 'store'])->name('store');
        Route::get('/{feed}', [FeedController::class, 'show'])->name('show');
        Route::get('/{feed}/edit', [FeedController::class, 'edit'])->name('edit');
        Route::post('/{feed}/edit', [FeedController::class, 'update'])->name('update');
        Route::delete('/{feed}', [FeedController::class, 'destroy'])->name('destroy');
    });
});
