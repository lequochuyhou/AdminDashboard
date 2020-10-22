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
    // Route::post('/edit_product', [\App\Http\Controllers\AdminController::class, 'editRole']);
    // Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

    //Brand
    Route::get('/get_brand', [\App\Http\Controllers\AdminController::class, 'getBrand']);
    Route::post('/create_product', [\App\Http\Controllers\AdminController::class, 'createProduct']);
    Route::post('/edit_product', [\App\Http\Controllers\AdminController::class, 'editProduct']);
    // Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

    //Supplier
    Route::get('/get_supplier', [\App\Http\Controllers\AdminController::class, 'getSupplier']);
    // Route::post('/create_product', [\App\Http\Controllers\AdminController::class, 'createProduct']);
    // Route::post('/edit_product', [\App\Http\Controllers\AdminController::class, 'editRole']);
    // Route::post('/assign_roles', [\App\Http\Controllers\AdminController::class, 'assignRole']);

});


Route::get('/logout', [\App\Http\Controllers\AdminController::class, 'logout']);

Route::get('/', [\App\Http\Controllers\AdminController::class, 'index']);


Route::any('{slug}', [\App\Http\Controllers\AdminController::class, 'index']);

// Route::get('/testpage', function () {
//     return view('welcome');
// });

// Route::get('/new',[\App\Http\Controllers\TestController::class,'controllerMethod']);

// Route::any('{slug}',function (){
//     return view('welcome');
// });
