<?php

use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::post('/create_user', [\App\Http\Controllers\AdminController::class, 'createUser']);
Route::prefix('app')->middleware(AdminCheck::class)->group(function () {

    //Tag
    Route::get('/get_tags', [\App\Http\Controllers\AdminController::class, 'getTag']);
    Route::post('/create_tag', [\App\Http\Controllers\AdminController::class, 'addTag']);
    Route::post('/edit_tag', [\App\Http\Controllers\AdminController::class, 'editTag']);
    Route::post('/delete_tag', [\App\Http\Controllers\AdminController::class, 'deleteTag']);

    //Category
    Route::get('/get_category', [\App\Http\Controllers\AdminController::class, 'getCategory']);
    Route::post('/upload', [\App\Http\Controllers\AdminController::class, 'upload']);
    Route::post('/create_category', [\App\Http\Controllers\AdminController::class, 'addCategory']);
    Route::post('/edit_category', [\App\Http\Controllers\AdminController::class, 'editCategory']);
    Route::post('/delete_category', [\App\Http\Controllers\AdminController::class, 'deleteCategory']);
    Route::post('/delete_image', [\App\Http\Controllers\AdminController::class, 'deleteImage']);

    //User
    Route::get('/get_users', [\App\Http\Controllers\AdminController::class, 'getUser']);
    Route::get('/get_allusers', [\App\Http\Controllers\AdminController::class, 'getAllUsers']);
    Route::post('/create_user', [\App\Http\Controllers\AdminController::class, 'createUser']);
    Route::post('/edit_user', [\App\Http\Controllers\AdminController::class, 'editUser']);
    Route::post('/admin_login', [\App\Http\Controllers\AdminController::class, 'adminLogin']);


    //Role
    Route::get('/get_roles', [\App\Http\Controllers\AdminController::class, 'getRole']);
    Route::post('/create_role', [\App\Http\Controllers\AdminController::class, 'addRole']);
    Route::post('/edit_role', [\App\Http\Controllers\AdminController::class, 'editRole']);
    Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

    //Product
    Route::get('/get_product', [\App\Http\Controllers\AdminController::class, 'getProduct']);
    Route::post('/create_product', [\App\Http\Controllers\AdminController::class, 'createProduct']);
     Route::post('/edit_product', [\App\Http\Controllers\AdminController::class, 'editProduct']);
    // Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

    //Brand
    Route::get('/get_brand', [\App\Http\Controllers\AdminController::class, 'getBrand']);
    Route::post('/create_brand', [\App\Http\Controllers\AdminController::class, 'createBrand']);
    Route::post('/edit_brand', [\App\Http\Controllers\AdminController::class, 'editProduct']);

    // Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

    //Supplier
    Route::get('/get_supplier', [\App\Http\Controllers\AdminController::class, 'getSupplier']);

    Route::get('/get_notification', [\App\Http\Controllers\AdminController::class, 'getNotification']);

    //Order
    Route::get('/get_order', [\App\Http\Controllers\AdminController::class, 'getOrder']);
    Route::post('/get_orderdetails',[\App\Http\Controllers\AdminController::class, 'getOrderById']);
    // Route::post('/create_product', [\App\Http\Controllers\AdminController::class, 'createProduct']);
    // Route::post('/edit_product', [\App\Http\Controllers\AdminController::class, 'editRole']);
    // Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

});


Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout']);

Route::get('/', [\App\Http\Controllers\AdminController::class, 'index']);
Route::get('/store/',[\App\Http\Controllers\StoreContoller::class, 'index']);

//Route::view('/store','storeWelcome');


Route::prefix('store')->group(function () {
   // Route::get('/product',[\App\Http\Controllers\StoreContoller::class, 'index']);
    //Route::get('/productdetails');

    //Authentication
    Route::post('/login',[\App\Http\Controllers\StoreContoller::class, 'login']);
    Route::get('/logout',[\App\Http\Controllers\StoreContoller::class, 'logout']);
    Route::post('/register', [\App\Http\Controllers\StoreContoller::class, 'register']);


    //Product
    Route::get('/get_product',[\App\Http\Controllers\StoreContoller::class, 'getProduct']);
    Route::get('/get_productdetails',[\App\Http\Controllers\StoreContoller::class, 'getProductById']);
    Route::get('/get_category',[\App\Http\Controllers\StoreContoller::class, 'getCategory']);
    Route::get('/get_brand',[\App\Http\Controllers\StoreContoller::class, 'getBrand']);
    Route::post('/search_product', [\App\Http\Controllers\StoreContoller::class, 'getProductByBrandAndCategory']);
    //Order
    Route::post('/get_order',[\App\Http\Controllers\StoreContoller::class, 'getOrder']);
    Route::post('/get_orderdetails',[\App\Http\Controllers\StoreContoller::class, 'getOrderById']);
    Route::post('/create_order', [\App\Http\Controllers\StoreContoller::class, 'createOrder']);

    //Conversation
    Route::get('/messages',[\App\Http\Controllers\StoreContoller::class, 'getMessages']);
    Route::post('/sendmessage',[\App\Http\Controllers\StoreContoller::class, 'sendMessage']);

   //Notification
    Route::get('/get_notifications',[\App\Http\Controllers\StoreContoller::class, 'getNotifications']);


    //Cart
    Route::post('/get_shoppingcart',[\App\Http\Controllers\StoreContoller::class, 'getShoppingCartById']);
    Route::post('/get_cartitems',[\App\Http\Controllers\StoreContoller::class, 'getCartItemsByShoppingCartId']);
    Route::post('/add_cartitem',[\App\Http\Controllers\StoreContoller::class, 'addCartItem']);
    Route::post('/update_cartitem_quantity',[\App\Http\Controllers\StoreContoller::class, 'updateCartItemQuantity']);
    Route::post('/delete_cartitem',[\App\Http\Controllers\StoreContoller::class, 'deleteCartItem']);
});

Route::any('{slug}', [\App\Http\Controllers\AdminController::class, 'index']);


