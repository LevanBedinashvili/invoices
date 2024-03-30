<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WarrantyTemplateController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\GetProductItemController;
use App\Http\Controllers\SmsController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/sms', [SmsController::class, 'sendSms']);
Route::get('/getbalance', [SmsController::class, 'getBalance']);
Route::get('/rs', [SmsController::class, 'getPersonStatus']);


Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/password', [ProfileController::class, 'change_password'])->name('profile.password');

    Route::get('/notifications/mark_as_seen', [NotificationsController::class, 'mark_as_seen'])->name('notification.mark_as_seen');
    Route::put('/notifications/mark_seen/{id}', [NotificationsController::class, 'mark_seen'])->name('notification.mark_seen');


    Route::resource('/users', UserController::class);
    Route::resource('/branch', BranchController::class);
    Route::resource('/product', ProductsController::class);
    Route::resource('/payment',  PaymentController::class);
    Route::resource('/warranty', WarrantyController::class);
    Route::resource('/templates', WarrantyTemplateController::class);
    Route::resource('/invoice', InvoiceController::class);
    Route::get('/getItems', [GetProductItemController::class, 'getItems'])->name('getItems');;
    Route::get('/getBranchItems', [GetProductItemController::class, 'getBranchItems'])->name('getBranchItems');;
    Route::get('/getTemplateItems', [GetProductItemController::class, 'getTemplateItems'])->name('getTemplateItems');;



    Route::get('/invoice/createIfExists/{id}', [InvoiceController::class, 'createIfExists'])->name('invoice.createIfExists');

    // Route::get('/clear-all-cache', function() {
    //     Artisan::call('optimize:clear');
    //     return 'Application all kind of cache has been cleared';
    // });
    // Route::get('/clear-cache', function() {
    //     Artisan::call('cache:clear');
    //     return 'Application cache has been cleared';
    // });
    // Route::get('/route-cache', function() {
    //     Artisan::call('route:cache');
    //     return 'Routes cache has been cleared';
    // });
    // Route::get('/config-cache', function() {
    //      Artisan::call('config:cache');
    //      return 'Config cache has been cleared';
    // });
    // Route::get('/view-clear', function() {
    //     Artisan::call('view:clear');
    //     return 'View cache has been cleared';
    // });

    Route::get('/loginout',[LogoutController::class, 'logout'])->name('user.logout');
});
