<?php

namespace App\Http\Controllers;

use App\Models\SalesInvoice;
use App\Services\XenditService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $xendit;

    public function __construct(XenditService $xendit)
    {
        $this->xendit = $xendit;
    }

    /**
     * Initiate Payment
     */
    public function initiate($invoiceId)
    {
        $invoice = SalesInvoice::findOrFail($invoiceId);

        try {
            $xenditInvoice = $this->xendit->createInvoice(
                $invoice->invoice_id,
                $invoice->total_amount,
                'Sales Invoice #' . $invoice->invoice_id,
                [
                    'name' => $invoice->salesOrder->customer->name,
                    'email' => $invoice->salesOrder->customer->email ?? 'noemail@tradeflow.com',
                    'phone' => $invoice->salesOrder->customer->phone,
                ]
            );

            // Simpan Xendit Invoice ID
            $invoice->update([
                'xendit_invoice_id' => $xenditInvoice['id'],
                'payment_url' => $xenditInvoice['invoice_url'],
            ]);

            return redirect($xenditInvoice['invoice_url']);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Payment Success Callback
     */
    public function success()
    {
        return view('payment.success');
    }

    /**
     * Payment Failed Callback
     */
    public function failed()
    {
        return view('payment.failed');
    }

    /**
     * Webhook Handler (untuk notifikasi dari Xendit)
     */
    public function webhook(Request $request)
    {
        $data = $request->all();

        // Validasi signature dari Xendit
        $token = hash_hmac(
            'sha256',
            $data['id'] . $data['status'],
            env('XENDIT_API_KEY')
        );

        if ($token !== $request->header('x-callback-token')) {
            return response()->json(['error' => 'Invalid token'], 403);
        }

        $invoice = SalesInvoice::where('xendit_invoice_id', $data['id'])->first();

        if ($invoice && $data['status'] === 'PAID') {
            $invoice->update(['payment_status' => 'paid']);
        }

        return response()->json(['success' => true]);
    }
}