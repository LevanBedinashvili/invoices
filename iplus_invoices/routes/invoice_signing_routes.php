// Invoice signing routes
Route::get('/sign/invoice/{uuid}', [InvoiceSignController::class, 'show'])->name('invoice.sign.show');
Route::post('/sign/invoice/{id}/verify', [InvoiceSignController::class, 'verify'])->name('invoice.sign.verify');
Route::get('/invoice/{uuid}/pdf', [InvoiceSignController::class, 'downloadPdf'])->name('invoice.pdf');
Route::post('/invoice/{uuid}/send-sms', [InvoiceSignController::class, 'sendSms'])->name('invoice.sendSms');
