<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Blog
Volt::route('/', 'home')->name('home');
Volt::route('blog', 'blog')->name('blog');
Volt::route('blog/{post}', 'show-post')->name('post');
Volt::route('about-us', 'about-us')->name('about-us');

// Shop
Volt::route('shop', 'shop.products')->name('shop');
Volt::route('shop/product/{product}', 'shop.product-details')->name('product-details');
Volt::route('shop/cart', 'shop.shopping-cart')->name('shopping-cart');
Volt::route('shop/order', 'shop.create-order')->name('create-order');
Volt::route('shop/order/payment-status', 'shop.order-payment-status')->name('order-payment-status');

// PayU Notifications
Route::post('shop/payment/notifications', App\Livewire\Actions\PayUNotifications::class)->withoutMiddleware([Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])->name('payment-notifications');

// User Dashboard
Route::middleware(['auth'])->group(function () {
    Volt::route('user/dashboard', 'user.dashboard')->name('user-dashboard');
});

// Admin dashboard
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
    Volt::route('/', 'admin.dashboard')->name('dashboard');
    // Blog
    Volt::route('blog', 'admin.blog')->name('blog');
    Volt::route('blog/post/create', 'admin.post-edit')->name('post-create');
    Volt::route('blog/post/{id}/edit', 'admin.post-edit')->name('post-update');
    // Products
    Volt::route('products', 'admin.products.products-list')->name('products-list');
    Volt::route('products/product/create', 'admin.products.product-edit')->name('product-create');
    Volt::route('products/product/{id}/edit', 'admin.products.product-edit')->name('product-update');
    // Orders
    Volt::route('orders', 'admin.orders.orders-list')->name('orders-list');
    Volt::route('orders/order/{id}', 'admin.orders.order-details')->name('order-details');
});

require __DIR__.'/auth.php';
