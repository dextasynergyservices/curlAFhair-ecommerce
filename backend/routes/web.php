<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SiteSettingsController;

Route::get('/', function () {
    return view('frontend.landing', ['title' => 'Welcome']);
});

Route::get('/shop', function () {
    return view('frontend.shop', ['title' => 'Shop']);
});

Route::get('/cart', function () {
    return view('frontend.cart', ['title' => 'Cart']);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

// Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

Route::prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [AdminProductController::class, 'index'])->name('index');
    Route::get('/create', [AdminProductController::class, 'create'])->name('create');
    Route::post('/', [AdminProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
    Route::post('/{product}/toggle', [AdminProductController::class, 'toggle'])->name('toggle');
    Route::post('/{product}/check-discount', [AdminProductController::class, 'checkDiscount'])->name('check-discount');
});

Route::prefix('admin/setings')->name('admin.settings.')->group(function () {
    Route::get('/', [SiteSettingsController::class, 'index'])->name('index');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to the home page after logout
})->name('logout');
