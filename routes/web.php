<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', \App\Livewire\HomePage::class);
Route::get('/categories', \App\Livewire\CategoriesPage::class);
Route::get('/products', \App\Livewire\ProductPage::class);
Route::get('/cart', \App\Livewire\CartPage::class);
Route::get('/products/{slug}', \App\Livewire\ProductDetailPage::class);

Route::middleware('guest')->group(function (){
    Route::get('/login', \App\Livewire\Auth\LoginPage::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\RegisterPage::class);
    Route::get('/reset/{token}', \App\Livewire\Auth\ResetPasswordPage::class)->name('password.reset');
    Route::get('/forgot', \App\Livewire\Auth\ForgotPage::class)->name('password.request');
});

Route::middleware('auth')->group(function (){
    Route::get('/logout', function (){
        auth()->logout();
        return redirect('/');
    });
    Route::get('/checkout', \App\Livewire\CheckoutPage::class);
    Route::get('/my-orders', \App\Livewire\MyOrdersPage::class);
    Route::get('/my-orders/{order}', \App\Livewire\MyOrderDetailPage::class);
    Route::get('/success', \App\Livewire\SuccessPage::class)->name('success');
    Route::get('/cancel', \App\Livewire\CartPage::class)->name('cancel');
});


