<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\AddBidController;

/*
|--------------------------------------------------------------------------
| E3tamd Front-End Routes
|--------------------------------------------------------------------------
|
| Here is Front-End Routes or E3tamd like shop aka store - product
| .. etc.
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/shop', [ShopController::class, 'index'])->name('shop');
    Route::get('/product/{slug}', [ProductController::class, 'index'])->name('product.info');

    /*
    Route::get('/about', function() {
        return view('front.about');
    })->name('about');
    */

    Route::get('/search', [SearchController::class, 'index'])->name("search");
    Route::get('/user/{username}', [UserController::class, 'index'])->name("user");
    
    Route::post('/user/comment/{userid}', [UserController::class, 'comment'])->name("user.store");
    
    Route::get('/categories/{categoryslug}', [CategoryController::class, 'index'])->name("category");

});

Route::post('add_bid', [AddBidController::class, 'index'])->name('add_bid');
