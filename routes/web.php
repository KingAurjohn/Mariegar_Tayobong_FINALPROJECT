<?php

use App\Http\Controllers\Admincontroller;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;




// !!!!!!!!!!!!!!!!!!!!! ATTENTION HERE !!!!!!!!!!!!!!!!!!!!!!!!!!!!
//the default email and password for super admin is:
    //email : superadmin@gmail.com
    //password : !Password123





//alias 'check' will check if user already logged in. If it is, then redirect to home.
Route::middleware('check')->get('/', function () {
    return view('pages.login');
})->name('login');

//alias 'login' use for authentication of user credentials.
Route::middleware('login')->group( function () {

    //if login success
    Route::post('/admin/log-in', function(){
        return response()->json(['message'=>'success']);
    });
});

//alias 'auth' use to check if user is authenticated.
Route::middleware('auth')->group( function () {

    Route::get('/home', function (){ 
        return view('pages.home');
    })->name('home');

    Route::get('/{p}', function (){
        return view('pages.home');
    })->whereIn("p", ['home', 'add-product', "logs", 'account-setting']);

    Route::post('/admin/add-product', [ProductController::class, "add_product"]);
    Route::post('/admin/edit-product', [ProductController::class, "edit_product"]);
    Route::get('/admin/get-products', [ProductController::class, "return_product"]);
    Route::post('/admin/add-quantity', [ProductController::class, "add_quantity"]);
    Route::post('/admin/delete-product', [ProductController::class, "delete_product"]);
    Route::get('/admin/return-logs', [ProductController::class, "returnLogs"]);
    Route::get('/logout', [Admincontroller::class, 'logout']);
    Route::get('/admin/return-info', [Admincontroller::class, "return_info"]);
    Route::post('/admin/update-info', [Admincontroller::class, "update_info"]);
});