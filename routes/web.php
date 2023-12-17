<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CouponWinningListsController;
use App\Http\Controllers\ListAppController;
use App\Http\Controllers\OrdinalImagesController;
use App\Http\Controllers\ScanHistoriesController;
use App\Http\Controllers\StampCardsController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/foo', function () {
    Artisan::call('storage:link');
});
Route::get('/file-link', function () {
    symlink(storage_path('app/public'), public_path('storage'));
});
Route::get('test', function () {
    return view('layout.test');
});
// login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'processLogin'])->name('process_login');
//
Route::group([
    'middleware' => 'login admin',
], function () {
    Route::get('admin/tour/create', [TourController::class, 'create'])->name('tour.create');
    Route::post('admin/tour/create', [TourController::class, 'store'])->name('tour.store');
    Route::get('admin/tour', [TourController::class, 'index'])->name('tour.index');
    Route::get('admin/tour/edit/{tour}', [TourController::class, 'edit'])->name('tour.edit');
    Route::post('admin/tour/edit/{tour}', [TourController::class, 'update'])->name('tour.update');
    Route::get('admin/stat', [TourController::class, 'stat'])->name('tour.stat');
    Route::get('admin/ratio', [TourController::class, 'ratio'])->name('tour.ratio');
    Route::group([
        'middleware' => 'app admin',
    ], function () {
        // 
        Route::get('admin', [ListAppController::class, 'index'])->name('admin');
        Route::post('admin', [ListAppController::class, 'chooseApp'])->name('choose.app');
        // thêm app
        Route::post('admin/create', [ListAppController::class, 'store'])->name('store.app');
        Route::get('admin/edit/{app}', [ListAppController::class, 'edit'])->name('app.edit');
        Route::post('admin/edit/{app}', [ListAppController::class, 'update'])->name('app.update');
        // thêm tour
        // Route::get('admin/tour/create', [TourController::class, 'create'])->name('tour.create');
        // Route::post('admin/tour/create', [TourController::class, 'store'])->name('tour.store');
        // Route::get('admin/tour', [TourController::class, 'index'])->name('tour.index');
        // Route::get('admin/tour/edit/{tour}', [TourController::class, 'edit'])->name('tour.edit');
        // Route::post('admin/tour/edit/{tour}', [TourController::class, 'update'])->name('tour.update');
        // Route::get('admin/stat', [TourController::class, 'stat'])->name('tour.stat');
        // Route::get('admin/ratio', [TourController::class, 'ratio'])->name('tour.ratio');

        Route::delete('admin/tour/destroy/{tour}', [TourController::class, 'destroy'])->name('tour.destroy');

        Route::delete('admin/destroy/{app}', [ListAppController::class, 'destroy'])->name('app.destroy');
        // list app admin account
        Route::get('admin/app', [AdminController::class, 'index'])->name('app.admin');
        Route::get('admin/app/edit/{app}', [AdminController::class, 'edit'])->name('app.admin.edit');
        Route::put('admin/app/edit/{app}', [AdminController::class, 'update'])->name('app.admin.update');
        Route::delete('admin/app/destroy/{app}', [AdminController::class, 'destroy'])->name('app.admin.destroy');
        // thêm tài khoản app admin
        Route::post('admin/app/create', [AdminController::class, 'store'])->name('store.app.admin');
        //
    });
    // Setting coupon
    // Route::get('admin/coupon', [CouponController::class, 'setting'])->name('setting.coupon');
    // Route::post('admin/coupon', [CouponController::class, 'store'])->name('store.coupon');
    // // Setting stamp card
    // Route::get('admin/stamp', [StampCardsController::class, 'setting'])->name('setting.stamp');
    // Route::post('admin/stamp', [StampCardsController::class, 'store'])->name('store.stamp');
    // // Setting image stamp card
    // Route::get('admin/stamp/image', [OrdinalImagesController::class, 'index'])->name('setting.image');
    // Route::post('admin/stamp/image', [OrdinalImagesController::class, 'store'])->name('store.image');
    // // Store management
    // Route::get('admin/store', [StoreController::class, 'index'])->name('store.management');
    // Route::post('admin/store', [StoreController::class, 'import'])->name('store.import');
    // // Export coupon
    // Route::get('admin/export', [CouponWinningListsController::class, 'index'])->name('coupon.winning.lists');
    // Route::post('admin/exporting', [CouponWinningListsController::class, 'export'])->name('export');
    //
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('appadmin', [AuthController::class, 'test'])->name('test');
});

// User
Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'processRegister'])->name('process_register');
Route::get('userLogin', [UserController::class, 'userLogin'])->name('user.login');
Route::post('userLogin', [UserController::class, 'login'])->name('user.logging.in');
Route::group([
    'middleware' => 'user',
], function () {
    // index
    Route::get('u/{id_app}', [UserController::class, 'index'])->name('user');
    // scan
    Route::get('user/{id_app}/{id_store}', [ScanHistoriesController::class, 'scan'])->name('user.scan');
    Route::post('user/{id_app}/{id_store}', [ScanHistoriesController::class, 'scanning'])->name('scanning');
    //coupon winning list
    Route::get('user/wincoupon', [CouponWinningListsController::class, 'getCoupon'])->name('get.coupon');
    Route::post('user/wincoupon', [CouponWinningListsController::class, 'processGetCoupon'])->name('process.get.coupon');
    //coupon detail
    Route::get('coupon', [CouponController::class, 'index'])->name('coupon.list');
    Route::get('coupon/{id_coupon}', [CouponWinningListsController::class, 'show'])->name('coupon.detail');
    // use coupon
    Route::post('coupon/{id_coupon}', [CouponWinningListsController::class, 'useCoupon'])->name('coupon.use');
    //log out
    Route::get('logoutuser', [UserController::class, 'logout'])->name('logout.user');
});
