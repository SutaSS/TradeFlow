<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])
    ->name('invoice.print')
    ->middleware('auth');
