<?php

use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Sales\SaleController;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/dashboard');
//    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::resource('products', ProductController::class);
    Route::post('products/pull',function(){
        Product::recache();

    })->name('products.pull');
    Route::resource('sales', SaleController::class);
    Route::post('sales/destroy_item/{id}',[SaleController::class,'destroy_item'])->name('sales.destroy_item');

});




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
