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

// add this route for remove after user add into the cart package
route::get('/remove_cart/{id}', [HomeController::class,'remove_cart']);

// add this route for for cash order

route::get('/cash_order', [HomeController::class,'cash_order']);

// add this route for payment stripe
route::get('/stripe/{totalprice}',[HomeController::class,'stripe']);

/*
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
Route::post('stripe/{totalprice}',[HomeController::class,'stripePost'])->name('stripe.post');

// add this route for create show order in user view page
route::get('/show_order', [HomeController::class,'show_order']);

// add this route for cancle order
route::get('/cancel_order/{id}', [HomeController::class,'cancel_order']);

// add this route for adding comment for user
route::post('/add_comment',[HomeController::class,'add_comment']);

// add this route for reply from user comment
route::post('/add_reply',[HomeController::class,'add_reply']);

// add this route for user to search product
route::get('/product_search',[HomeController::class,'product_search']);

// add this to show user how many product
route::get('/products',[HomeController::class,'product']);

route::get('/search_product',[HomeController::class,'search_product']);



