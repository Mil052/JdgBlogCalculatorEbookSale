<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'home')->name('home');
Volt::route('blog', 'blog')->name('blog');
Volt::route('blog/{post}', 'show-post')->name('post');
Volt::route('shop', 'shop.products')->name('shop');
Volt::route('shop/product/{product}', 'shop.product-details')->name('product-details');
Volt::route('shop/cart', 'shop.shopping-cart')->name('shopping-cart');

Route::middleware(['auth'])->group(function () {
    Volt::route('dashboard', 'user.dashboard')->name('dashboard');
    
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function () {
    Volt::route('/', 'admin.dashboard')->name('dashboard');
    Volt::route('blog', 'admin.blog')->name('blog');
    Volt::route('blog/post/create', 'admin.post-edit')->name('post-create');
    Volt::route('blog/post/{id}/edit', 'admin.post-edit')->name('post-update');
});

require __DIR__.'/auth.php';
