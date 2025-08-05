<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard routes
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Store management routes (Super Admin only)
    Route::resource('stores', StoreController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
