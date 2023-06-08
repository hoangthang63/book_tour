<?php

use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\ReceiptController;
use App\Models\Receipt;
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
Route::post('/login', [KhachHangController::class, 'login']);
Route::post('/register', [KhachHangController::class, 'register']);
Route::post('/forget-password', [KhachHangController::class, 'forgetPassword']);

Route::group([
    'middleware' => 'auth api',
], function () {
    Route::post('/change-password', [KhachHangController::class, 'changePassword']);
    Route::post('/profile', [KhachHangController::class, 'profile']);
    Route::post('/edit/profile', [KhachHangController::class, 'editProfile']);
    Route::post('/payment', [ReceiptController::class, 'payment']);
    Route::post('/purchased-order', [ReceiptController::class, 'purchasedOrder']);

});

Route::get('/list-tour', [TourController::class, 'index']);
Route::get('/tour/detail', [TourController::class, 'detail']);
