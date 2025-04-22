<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberDashboardController;

Route::get('/', function () {
    return view('frontend.landing', ['title' => 'Welcome']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to the home page after logout
})->name('logout');
