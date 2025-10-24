<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;

// مسارات تصحيح نظام التقييم
Route::prefix('debug')->middleware(['web'])->group(function () {
    Route::get('/test-rating', [DebugController::class, 'testRating'])->name('debug.test-rating');
    Route::post('/test-rating', [DebugController::class, 'testAddRating'])->name('debug.add-rating');
    Route::get('/reviews', [DebugController::class, 'viewReviews'])->name('debug.reviews');
    
});
