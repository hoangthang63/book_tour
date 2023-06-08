<?php

use App\Http\Controllers\Api\TourController;
use App\Http\Controllers\KhachHangController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/list-tour', [TourController::class, 'index'])->name('list.tour');

Route::post('/login', [KhachHangController::class, 'login']);
Route::post('/register', [KhachHangController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/list-tour', [TourController::class, 'index'])->name('list.tour');
    // Route::get('/users', 'UserController@index');
});
Route::group([
    'middleware' => 'auth api',
], function () {
    Route::post('/change-password', [KhachHangController::class, 'changePassword']);
    Route::post('/forget-password', [KhachHangController::class, 'forgetPassword']);

});

Route::get('/list-tour', [TourController::class, 'index'])->name('list.tour');
Route::get('/tour/detail', [TourController::class, 'detail']);
