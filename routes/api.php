<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TicketController;
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
Route::post('/login-staff', [AuthController::class, 'loginStaff']);
Route::post('/register', [KhachHangController::class, 'register']);
Route::post('/forget-password', [KhachHangController::class, 'forgetPassword']);
Route::get('/status-payment', [ReceiptController::class, 'statusPayment']);

Route::group([
    'middleware' => 'auth api',
], function () {
    Route::post('/change-password', [KhachHangController::class, 'changePassword']);
    Route::post('/profile', [KhachHangController::class, 'profile']);
    Route::post('/edit/profile', [KhachHangController::class, 'editProfile']);
    Route::post('/payment', [ReceiptController::class, 'payment']);
    Route::post('/purchased-order', [ReceiptController::class, 'purchasedOrder']);

});

// Route::group([
//     'middleware' => 'auth api',
// ], function () {
//     Route::post('/scan', [TicketController::class, 'scan']);
// });
Route::post('/scan', [TicketController::class, 'scan']);
Route::get('/list-tour-today', [TicketController::class, 'listTour']);

Route::get('/list-tour', [TourController::class, 'index']);
Route::get('/tour/detail', [TourController::class, 'detail']);
