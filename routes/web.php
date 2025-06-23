<?php

use App\Http\Controllers\Products\ProductController;
use App\Http\Controllers\Sales\SaleController;
use App\Http\Middleware\HandelSheft;
use App\Models\Products\Product;
use App\Models\Sales\Sheft;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    Sheft::cacheLast();
    return redirect('/dashboard');
//    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('sheft',function (){
        return Inertia::render('sheft');
    })->name('sheft');



    Route::post('sheft',function (){
        $sh=Sheft::create([
            'date'=>request()->date,
            'user_id'=>auth()->id(),
            'inBox'=>request()->inBox??0,
        ]);
//        Cache::put('sheft',);
        Sheft::recache($sh->id);
        return redirect()->route('sales.index');
    })->name('sheft.store');



    Route::post('sheft-close',function ($id){
        Sheft::query()->find($id)->update(['is_closed'=>1]);
        Cache::forget('sheft');
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->route('dashboard');
    })->name('sheft.close');

    Route::get('dashboard', function () {

        return Inertia::render('dashboard',[
            'sheft'=>Cache::get('sheft'),
        ]);
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
