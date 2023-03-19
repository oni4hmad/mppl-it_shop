<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PlaceOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\ProductOrderController;
use App\Http\Controllers\ProductOrderManagementController;
use App\Http\Controllers\ProductRatingController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProductStackCartController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\ServiceOrderManagementController;
use App\Http\Controllers\TechnicianController;
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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::controller(RegistrationController::class)->group(function () {
    Route::get('/register', 'create')->middleware('guest');
    Route::post('/register', 'store')->middleware('guest');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->middleware('guest');
    Route::post('/login', 'login')->middleware('guest')->name('login');
    Route::get('/logout', 'logout')->middleware('auth');
});


Route::controller(AccountSettingsController::class)->group(function () {
    Route::get('/account-settings', 'edit')->middleware('auth');
    Route::put('/account-settings', 'update')->middleware('auth');
});

Route::controller(CategoryController::class)->group(function () {
    Route::post('/category', 'store')->middleware('auth.admin');
});

// TODO: route not done yet
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth.admin');

Route::controller(ProductManagementController::class)->group(function () {
    Route::get('/manage-product', 'index')->middleware('auth.admin');
});

Route::controller(ProductController::class)->group(function () {
    Route::post('/manage-product', 'store')->middleware('auth.admin');
    Route::put('/manage-product', 'update')->middleware('auth.admin');
    Route::delete('/manage-product/{id}/delete', 'delete')->middleware('auth.admin');
});

// TODO: route not done yet
Route::controller(ProductOrderManagementController::class)->group(function () {
    Route::get('/manage-product-order', 'index')->middleware('auth.admin');
    Route::post('/confirm-payment/{productOrder:id}', 'confirmPayment')->middleware('auth.admin');
    Route::post('/update-resi/{productOrder:id}', 'updateResi')->middleware('auth.admin');
});

Route::controller(ProductSearchController::class)->group(function () {
    Route::get('/search', 'index');
    Route::get('/product/{product:slug}', 'show');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->middleware('auth');
    Route::post('/cart', 'store')->middleware('auth');
});

Route::controller(ProductStackCartController::class)->group(function () {
    Route::put('/cart/{productStackCart:id}', 'update')->middleware('auth');
    Route::delete('/cart/{productStackCart:id}', 'delete')->middleware('auth');
});

Route::controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'index')->middleware('auth');
    Route::post('/checkout/{product:id}', 'directCheckout')->middleware('auth');
});

Route::controller(PlaceOrderController::class)->group(function () {
    Route::post('/place-order', 'store')->middleware('auth');
});

Route::controller(PaymentController::class)->group(function () {
    Route::get('/payment/{productOrder:id}', 'show')->middleware('auth');
});

Route::controller(ProductOrderController::class)->group(function () {
    Route::get('/order-history-product', 'index')->middleware('auth');
    Route::put('/payment/{productOrder:id}', 'update')->middleware('auth');
    Route::post('/cancel-order-product/{productOrder:id}', 'cancel')->middleware('auth');
    Route::get('/track/{productOrder:id}', 'track')->middleware('auth');
    Route::put('/mark-order-done/{productOrder:id}', 'markDone')->middleware('auth');
});

Route::controller(ProductRatingController::class)->group(function () {
    Route::post('/product-rating/{productStackOrder:id}', 'store')->middleware('auth');
});

Route::controller(ServiceOrderController::class)->group(function () {
    Route::get('/service-order', 'showForm')->middleware('auth');
    Route::post('/service-order', 'store')->middleware('auth');
    Route::post('/service-order/{serviceOrder:id}/cancel', 'cancel')->middleware('auth');
    Route::get('/order-history-service', 'index')->middleware('auth');
});

Route::controller(ServiceOrderManagementController::class)->group(function () {
    Route::get('/manage-service-order', 'index')->middleware('auth.admin');
});

// TODO: route not done yet
Route::controller(TechnicianController::class)->group(function () {
    Route::get('/manage-technician', 'index')->middleware('auth.admin');
});

// TODO: route not done yet
Route::get('/confirm-service-availability', function () {
    return view('technician.confirm-service-availability');
});




Route::get('/test', function () {
//    return view('playground._test-pg', [
//        "name" => "oni",
//        "email" => "oni@oni.com"
//    ]);
    return view('errors.404');
});
