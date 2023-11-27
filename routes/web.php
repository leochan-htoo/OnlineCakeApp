<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
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

route::get('/', [HomeController::class,'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// add this route for view redirect admin panel dashboard in admin
route::get('/redirect', [HomeController::class,'redirect']);

// add this route for view catagory in admin
route::get('/view_catagory', [AdminController::class,'view_catagory']);

// add this route for view product in admin
route::post('/add_catagory', [AdminController::class,'add_catagory']);

// add this route for delete product in admin
route::get('/delete_catagory/{id}', [AdminController::class,'delete_catagory']);

// add this route for view product in admin
route::get('/view_product', [AdminController::class,'view_product']);


// add this route for add product in admin
route::post('/add_product', [AdminController::class,'add_product']);

// add this route for show product in admin
route::get('/show_product', [AdminController::class,'show_product']);

// add this route for delete action
route::get('/delete_product/{id}', [AdminController::class,'delete_product']);

// add this route for update action
route::get('/update_product/{id}', [AdminController::class,'update_product']);

// add this route for update to edit in database table
route::post('/update_product_confirm/{id}', [AdminController::class,'update_product_confirm']);

// add this route for show product details
route::get('/product_details/{id}', [HomeController::class,'product_details']);

// add this route for adding product to the cart
route::post('/add_cart/{id}', [HomeController::class,'add_cart']);

// add this route for show product to the cart
route::get('/show_cart', [HomeController::class,'show_cart']);

// add this route for remove after user add into cart adding
route::get('/remove_cart/{id}', [HomeController::class,'remove_cart']);
