<?php

// Reviews Management Routes
Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->except(['create', 'store']);
Route::patch('reviews/{review}/toggle-approval', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleApproval'])->name('reviews.toggle-approval'); 