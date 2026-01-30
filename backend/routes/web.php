<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCouponController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\SiteSettingsController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Frontend Routes
Route::get('/', [ShopController::class, 'landing'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.show');

// Cart Routes
Route::middleware(['rate.cart'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
});

// Coupon & Promo Code Routes
Route::middleware(['rate.coupon'])->group(function () {
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
    Route::post('/cart/promo', [CartController::class, 'applyPromoCode'])->name('cart.promo.apply');
});

Route::get('/promo', function () {
    return view('frontend.promo', ['title' => 'Promo']);
})->name('promo');

// Checkout Routes (Auth Required with Rate Limiting)
Route::middleware(['auth', 'rate.checkout'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/order/{order}/success', [CheckoutController::class, 'success'])->name('order.success');
});

// Payment Callbacks
Route::get('/payment/callback/paystack', [CheckoutController::class, 'paystackCallback'])->name('payment.callback.paystack');
Route::get('/payment/callback/paypal', [CheckoutController::class, 'paypalCallback'])->name('payment.callback.paypal');
Route::get('/payment/callback/stripe', [CheckoutController::class, 'stripeCallback'])->name('payment.callback.stripe');

// User Dashboard
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    
    // Member Loyalty Routes
    Route::get('/rewards/redeem', [MemberDashboardController::class, 'redeemRewards'])->name('member.rewards.redeem');
    Route::get('/points/history', [MemberDashboardController::class, 'pointsHistory'])->name('member.points.history');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/promo', function () {
        return view('admin.promo.index', ['title' => 'Promo']);
    })->name('promo.index');

    // Coupons
    Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
    Route::get('/coupons/create', [AdminCouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons/{coupon}/edit', [AdminCouponController::class, 'edit'])->name('coupons.edit');
    Route::put('/coupons/{coupon}', [AdminCouponController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');
    Route::post('/coupons/{coupon}/toggle', [AdminCouponController::class, 'toggle'])->name('coupons.toggle');

    // Categories
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/{category}/toggle', [AdminCategoryController::class, 'toggle'])->name('categories.toggle');

    // Users Management
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/toggle', [AdminUserController::class, 'toggle'])->name('users.toggle');

    // Settings
    Route::get('/settings', [SiteSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SiteSettingsController::class, 'update'])->name('settings.update');
});

// Admin Products Routes
Route::middleware(['auth', 'admin'])->prefix('admin/products')->name('admin.products.')->group(function () {
    Route::get('/', [AdminProductController::class, 'index'])->name('index');
    Route::get('/create', [AdminProductController::class, 'create'])->name('create');
    Route::post('/', [AdminProductController::class, 'store'])->name('store');
    Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
    Route::post('/{product}/toggle', [AdminProductController::class, 'toggle'])->name('toggle');
    Route::post('/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('toggle-featured');
    Route::post('/{product}/toggle-promo', [AdminProductController::class, 'togglePromo'])->name('toggle-promo');
    Route::post('/{product}/check-discount', [AdminProductController::class, 'checkDiscount'])->name('check-discount');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirect to the home page after logout
})->name('logout');
