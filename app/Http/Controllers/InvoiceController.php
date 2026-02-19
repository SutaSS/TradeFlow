<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function print(SalesInvoice $invoice)
    {
        // Load relationships
        $invoice->load([
            'customer',
            'salesOrder',
            'details.product'
        ]);

        return view('invoices.print', [
            'invoice' => $invoice
        ]);
    }
}
