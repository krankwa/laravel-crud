<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return redirect(route('products.index')); 
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/products', function () {
        return view('products.index');
    })->name('products.index');
});