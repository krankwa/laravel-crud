<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Livewire\Auth\Login;

Route::get('/', function () {
    return redirect(route('products.index')); 
});

// Livewire Login Route
Route::get('/login', Login::class)->name('login')->middleware('guest');

// Keep other auth routes but override login
Auth::routes(['login' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/products', function () {
        return view('products.index');
    })->name('products.index');
});