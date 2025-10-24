<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SiteReviewController;

// مسارات إدارة التقييمات والمراجعات
Route::prefix('admin')->name('admin.')->middleware(['auth', 'customer'])->group(function () {
    Route::resource('reviews', ReviewController::class)->except(['create', 'store']);
    Route::patch('reviews/{review}/toggle-approval', [ReviewController::class, 'toggleApproval'])->name('reviews.toggle-approval');
    
    // مسارات إدارة تقييمات الموقع
    Route::resource('site-reviews', SiteReviewController::class);
    Route::patch('site-reviews/{siteReview}/toggle-approval', [SiteReviewController::class, 'toggleApproval'])->name('site-reviews.toggle-approval');
}); 