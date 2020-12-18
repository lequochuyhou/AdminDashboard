<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/product',[\App\Http\Controllers\StoreContoller::class,'getProduct']);
Route::get('/brand',[\App\Http\Controllers\StoreContoller::class,'getBrand']);
Route::get('/category',[\App\Http\Controllers\StoreContoller::class,'getCategory']);
Route::get('/order',[\App\Http\Controllers\StoreContoller::class,'getOrder']);

Route::post('/search_product',[\App\Http\Controllers\StoreContoller::class,'getProductByBrandAndCategory']);

Route::post('/add_cartitem',[\App\Http\Controllers\StoreContoller::class,'addCartItem']);
Route::post('/get_shoppingcart',[\App\Http\Controllers\StoreContoller::class,'getShoppingCartById']);

Route::post('/update_cartitem_quantity',[\App\Http\Controllers\StoreContoller::class,'updateCartItemQuantity']);

Route::post('/delete_cartitem',[\App\Http\Controllers\StoreContoller::class,'deleteCartItem']);
