<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SiteReviewController;

// مسارات إدارة تقييمات الموقع الرئيسية
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('site-reviews', SiteReviewController::class);
    Route::patch('site-reviews/{site_review}/toggle-approval', [SiteReviewController::class, 'toggleApproval'])->name('site-reviews.toggle-approval');
}); 