<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])
    ->name('invoice.print')
    ->middleware('auth');

Route::get('/payment/{invoiceId}/initiate', [PaymentController::class, 'initiate'])
    ->name('payment.initiate')
    ->middleware('auth');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');
Route::post('/webhook/xendit', [PaymentController::class, 'webhook'])->name('webhook.xendit');