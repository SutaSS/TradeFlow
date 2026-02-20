<?php

namespace App\Console\Commands;

use App\Models\SalesInvoice;
use App\Models\SalesOrder;
use Illuminate\Console\Command;

class CreateTestInvoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:test-create {--so_id=1 : Sales Order ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test invoice for Xendit payment testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $so_id = $this->option('so_id');

        $salesOrder = SalesOrder::find($so_id);
        if (!$salesOrder) {
            $this->error("Sales Order #{$so_id} not found!");
            return 1;
        }

        try {
            $invoice = SalesInvoice::create([
                'invoice_date' => now(),
                'due_date' => now()->addDays(7),
                'customer_id' => $salesOrder->customer_id,
                'so_id' => $salesOrder->so_id,
                'subtotal' => $salesOrder->subtotal,
                'tax' => $salesOrder->tax,
                'total_amount' => $salesOrder->total_amount,
                'signed_by' => auth()->id() ?? 1,
                'status' => 'Unpaid',
                'payment_status' => 'unpaid',
            ]);

            $this->info("✅ Test Invoice Created Successfully!");
            $this->info("Invoice ID: {$invoice->sales_invoice_id}");
            $this->info("Amount: IDR " . number_format($invoice->total_amount, 2));
            $this->info("Customer: {$salesOrder->customer->name}");
            $this->info("");
            $this->line("Next: Go to Admin → Sales Invoices");
            $this->line("Click 'Request Payment' button to initiate Xendit payment");

            return 0;
        } catch (\Exception $e) {
            $this->error("Error creating invoice: " . $e->getMessage());
            return 1;
        }
    }
}
