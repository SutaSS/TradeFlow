<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceDetail;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderDetail;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        SalesInvoiceDetail::truncate();
        SalesInvoice::truncate();
        DeliveryOrderDetail::truncate();
        DeliveryOrder::truncate();
        SalesOrderDetail::truncate();
        SalesOrder::truncate();
        PurchaseOrderDetail::truncate();
        PurchaseOrder::truncate();
        PurchaseRequisitionDetail::truncate();
        PurchaseRequisition::truncate();
        Product::truncate();
        Customer::truncate();
        Supplier::truncate();
        DB::table('m_user')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Users in m_user table
        DB::table('m_user')->insert([
            ['user_id' => 1, 'name' => 'Admin', 'role' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'name' => 'Sales Manager', 'role' => 'Sales', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'name' => 'Purchase Manager', 'role' => 'Purchasing', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Create Suppliers
        $suppliers = [
            ['name' => 'PT Supplier Elektronik', 'address' => 'Jl. Industri No. 123, Jakarta', 'phone' => '021-12345678'],
            ['name' => 'CV Mitra Jaya', 'address' => 'Jl. Perdagangan No. 45, Bandung', 'phone' => '022-87654321'],
            ['name' => 'UD Sejahtera', 'address' => 'Jl. Makmur No. 78, Surabaya', 'phone' => '031-11223344'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        // Create Customers
        $customers = [
            ['name' => 'PT Maju Bersama', 'address' => 'Jl. Sudirman No. 1, Jakarta', 'phone' => '021-55556666'],
            ['name' => 'CV Sukses Selalu', 'address' => 'Jl. Gatot Subroto No. 22, Jakarta', 'phone' => '021-77778888'],
            ['name' => 'Toko Berkah', 'address' => 'Jl. Ahmad Yani No. 88, Bandung', 'phone' => '022-99990000'],
            ['name' => 'UD Lancar Jaya', 'address' => 'Jl. Pahlawan No. 55, Surabaya', 'phone' => '031-44445555'],
            ['name' => 'PT Global Trading', 'address' => 'Jl. Thamrin No. 99, Jakarta', 'phone' => '021-33334444'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Create Products
        $products = [
            ['sku' => 'LAP-001', 'name' => 'Laptop Dell Latitude 5420', 'stock' => 50, 'price' => 12500000],
            ['sku' => 'MON-001', 'name' => 'Monitor LG 24 Inch', 'stock' => 100, 'price' => 2500000],
            ['sku' => 'KEY-001', 'name' => 'Keyboard Logitech MX Keys', 'stock' => 150, 'price' => 1500000],
            ['sku' => 'MOU-001', 'name' => 'Mouse Wireless Logitech', 'stock' => 200, 'price' => 350000],
            ['sku' => 'PRT-001', 'name' => 'Printer HP LaserJet Pro', 'stock' => 30, 'price' => 4500000],
            ['sku' => 'RTR-001', 'name' => 'Router TP-Link AC1750', 'stock' => 80, 'price' => 750000],
            ['sku' => 'WBC-001', 'name' => 'Webcam Logitech C920', 'stock' => 60, 'price' => 1200000],
            ['sku' => 'HDS-001', 'name' => 'Headset Gaming HyperX', 'stock' => 90, 'price' => 950000],
            ['sku' => 'SSD-001', 'name' => 'SSD Samsung 1TB', 'stock' => 120, 'price' => 1800000],
            ['sku' => 'RAM-001', 'name' => 'RAM DDR4 16GB Corsair', 'stock' => 75, 'price' => 1100000],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create Sales Orders
        $salesOrders = [
            [
                'so_date' => '2026-02-01',
                'customer_id' => 1,
                'subtotal' => 51000000,
                'tax' => 5610000,
                'total_amount' => 56610000,
                'signed_by' => 1,
                'status' => 'Approved',
            ],
            [
                'so_date' => '2026-02-05',
                'customer_id' => 2,
                'subtotal' => 28500000,
                'tax' => 3135000,
                'total_amount' => 31635000,
                'signed_by' => 1,
                'status' => 'Approved',
            ],
            [
                'so_date' => '2026-02-10',
                'customer_id' => 3,
                'subtotal' => 15750000,
                'tax' => 1732500,
                'total_amount' => 17482500,
                'signed_by' => 1,
                'status' => 'Pending',
            ],
        ];

        foreach ($salesOrders as $index => $soData) {
            $so = SalesOrder::create($soData);

            // Add details for each sales order
            if ($index === 0) {
                // SO 1: Laptops and Monitors
                SalesOrderDetail::create([
                    'so_id' => $so->so_id,
                    'product_id' => 1,
                    'qty' => 3,
                    'price' => 12500000,
                    'discount' => 500000,
                    'total_price' => 37000000,
                ]);
                SalesOrderDetail::create([
                    'so_id' => $so->so_id,
                    'product_id' => 2,
                    'qty' => 6,
                    'price' => 2500000,
                    'discount' => 1000000,
                    'total_price' => 14000000,
                ]);
            } elseif ($index === 1) {
                // SO 2: Printers and Routers
                SalesOrderDetail::create([
                    'so_id' => $so->so_id,
                    'product_id' => 5,
                    'qty' => 5,
                    'price' => 4500000,
                    'discount' => 500000,
                    'total_price' => 22000000,
                ]);
                SalesOrderDetail::create([
                    'so_id' => $so->so_id,
                    'product_id' => 6,
                    'qty' => 10,
                    'price' => 750000,
                    'discount' => 500000,
                    'total_price' => 7000000,
                ]);
            } else {
                // SO 3: Keyboards and Mice
                SalesOrderDetail::create([
                    'so_id' => $so->so_id,
                    'product_id' => 3,
                    'qty' => 8,
                    'price' => 1500000,
                    'discount' => 250000,
                    'total_price' => 11750000,
                ]);
                SalesOrderDetail::create([
                    'so_id' => $so->so_id,
                    'product_id' => 4,
                    'qty' => 12,
                    'price' => 350000,
                    'discount' => 200000,
                    'total_price' => 4000000,
                ]);
            }
        }

        // Create Sales Invoices for first 2 SOs
        for ($i = 1; $i <= 2; $i++) {
            $so = SalesOrder::find($i);
            
            $invoice = SalesInvoice::create([
                'invoice_date' => now()->subDays(10 - $i * 3),
                'due_date' => now()->addDays(30 - $i * 3),
                'customer_id' => $so->customer_id,
                'so_id' => $so->so_id,
                'subtotal' => $so->subtotal,
                'tax' => $so->tax,
                'total_amount' => $so->total_amount,
                'signed_by' => 1,
                'status' => $i === 1 ? 'Paid' : 'Unpaid',
            ]);

            // Copy details from SO to Invoice
            $soDetails = SalesOrderDetail::where('so_id', $so->so_id)->get();
            foreach ($soDetails as $detail) {
                SalesInvoiceDetail::create([
                    'sales_invoice_id' => $invoice->sales_invoice_id,
                    'product_id' => $detail->product_id,
                    'qty' => $detail->qty,
                    'price' => $detail->price,
                    'discount' => $detail->discount,
                    'total_price' => $detail->total_price,
                ]);
            }
        }

        // Create Delivery Orders for first SO
        $deliveryOrder = DeliveryOrder::create([
            'so_id' => 1,
            'do_date' => now()->subDays(5),
            'delivered_by' => 1, // User ID admin
        ]);

        // Copy details from SO to DO
        $soDetails = SalesOrderDetail::where('so_id', 1)->get();
        foreach ($soDetails as $detail) {
            DeliveryOrderDetail::create([
                'do_id' => $deliveryOrder->do_id,
                'product_id' => $detail->product_id,
                'qty_delivered' => $detail->qty,
                'description' => 'Delivered in good condition',
            ]);
        }

        // Create Purchase Requisitions
        $purchaseRequisitions = [
            [
                'pr_date' => '2026-01-10',
                'required_date' => '2026-01-25',
                'requested_by' => 3,
                'approved_by' => 1,
                'status' => 'Approved',
            ],
            [
                'pr_date' => '2026-01-15',
                'required_date' => '2026-01-30',
                'requested_by' => 3,
                'approved_by' => 1,
                'status' => 'Approved',
            ],
        ];

        foreach ($purchaseRequisitions as $prData) {
            $pr = \App\Models\PurchaseRequisition::create($prData);
        }

        // Create Purchase Orders
        $purchaseOrders = [
            [
                'pr_id' => 1,
                'po_date' => '2026-01-15',
                'required_date' => '2026-01-25',
                'supplier_id' => 1,
                'subtotal' => 45000000,
                'tax' => 4950000,
                'total_amount' => 49950000,
                'approved_by' => 1,
                'status' => 'Approved',
            ],
            [
                'pr_id' => 2,
                'po_date' => '2026-01-20',
                'required_date' => '2026-01-30',
                'supplier_id' => 2,
                'subtotal' => 18500000,
                'tax' => 2035000,
                'total_amount' => 20535000,
                'approved_by' => 1,
                'status' => 'Approved',
            ],
        ];

        foreach ($purchaseOrders as $index => $poData) {
            $po = PurchaseOrder::create($poData);

            if ($index === 0) {
                PurchaseOrderDetail::create([
                    'po_id' => $po->po_id,
                    'product_id' => 1,
                    'qty' => 4,
                    'price' => 11000000,
                    'discount' => 500000,
                    'total_price' => 43500000,
                ]);
            } else {
                PurchaseOrderDetail::create([
                    'po_id' => $po->po_id,
                    'product_id' => 5,
                    'qty' => 5,
                    'price' => 3800000,
                    'discount' => 500000,
                    'total_price' => 18500000,
                ]);
            }
        }

        $this->command->info('✅ Sample data created successfully!');
        $this->command->info('📦 Created: 3 Suppliers, 5 Customers, 10 Products');
        $this->command->info('📝 Created: 3 Sales Orders with details');
        $this->command->info('📄 Created: 2 Sales Invoices with details');
        $this->command->info('🚚 Created: 1 Delivery Order with details');
        $this->command->info('🛒 Created: 2 Purchase Orders with details');
    }
}
