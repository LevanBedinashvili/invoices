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
use App\Http\Controllers\FilterController;
use App\Http\Controllers\WarrantyPdfController;
use App\Http\Controllers\WarrantySignController;
use App\Http\Controllers\InvoiceSignController;
use App\Http\Controllers\InvoicePdfController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/sms', [SmsController::class, 'sendSms']);
// Route::get('/getbalance', [SmsController::class, 'getBalance']);

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
    Route::post('/warranty/{id}/send-sign-sms', [WarrantyController::class, 'sendSignSms'])->name('warranty.sendSignSms');
    Route::resource('/templates', WarrantyTemplateController::class);
    Route::resource('/invoice', InvoiceController::class);
    Route::get('/getItems', [GetProductItemController::class, 'getItems'])->name('getItems');;
    Route::get('/getBranchItems', [GetProductItemController::class, 'getBranchItems'])->name('getBranchItems');;
    Route::get('/getTemplateItems', [GetProductItemController::class, 'getTemplateItems'])->name('getTemplateItems');;

    Route::get('/invoice/createIfExists/{id}', [InvoiceController::class, 'createIfExists'])->name('invoice.createIfExists');

    Route::get('/invoices/search', [InvoiceController::class, 'search'])->name('invoices.search');


    Route::get('/filter/invoice_search', [FilterController::class, 'invoice_search'])->name('filter.invoice_search');
    Route::get('/filter/warranty_search', [FilterController::class, 'warranty_search'])->name('filter.warranty_search');

    Route::get('/loginout',[LogoutController::class, 'logout'])->name('user.logout');
});


// Public ხელმოწერის გვერდი უნიკალური ლინკით
Route::get('/warranty/sign/{uuid}', [WarrantySignController::class, 'show'])->name('warranty.sign.public');
Route::post('/warranty/sign/{uuid}/send-sms', [WarrantySignController::class, 'sendSms'])->name('warranty.sign.sendSms');
Route::post('/warranty/sign/{uuid}/verify', [WarrantySignController::class, 'verify'])->name('warranty.sign.verify');
Route::get('/warranty/pdf/{uuid}', [WarrantySignController::class, 'downloadPdf'])->name('warranty.downloadPdf');
Route::get('/warranty/{id}/pdf', [WarrantyPdfController::class, 'download'])->name('warranty.pdf');

// Public ინვოისის ხელმოწერის გვერდი უნიკალური ლინკით
Route::get('/invoice/sign/{uuid}', [InvoiceSignController::class, 'show'])->name('invoice.sign.show');
Route::post('/invoice/sign/{uuid}/send-sms', [InvoiceSignController::class, 'sendSms'])->name('invoice.sign.sendSms');
Route::post('/invoice/sign/{uuid}/verify', [InvoiceSignController::class, 'verify'])->name('invoice.sign.verify');
Route::get('/invoice/pdf/{uuid}', [InvoiceSignController::class, 'downloadPdf'])->name('invoice.downloadPdf');
Route::post('/invoice/{id}/send-sign-sms', [InvoiceController::class, 'sendSignSms'])->name('invoice.sendSignSms');
Route::get('/invoice/{id}/pdf', [InvoicePdfController::class, 'download'])->name('invoice.pdf');
Route::get('/warranty/{id}/preview', [WarrantyPdfController::class, 'preview'])->name('warranty.preview');