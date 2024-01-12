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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

    Route::get('/invoice/createIfExists/{id}', [InvoiceController::class, 'createIfExists'])->name('invoice.createIfExists');


    Route::get('/loginout',[LogoutController::class, 'logout'])->name('user.logout');
});
