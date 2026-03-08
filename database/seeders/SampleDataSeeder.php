<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderDetail;
use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptDetail;
use App\Models\Product;
use App\Models\PurchaseInvoice;
use App\Models\PurchaseInvoiceDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\PurchasePayment;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseRequisitionDetail;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\SalesInvoice;
use App\Models\SalesInvoiceDetail;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\SalesPayment;
use App\Models\SalesReturn;
use App\Models\SalesReturnDetail;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear all tables (reverse dependency order)
        PurchaseReturnDetail::truncate();
        PurchaseReturn::truncate();
        PurchasePayment::truncate();
        PurchaseInvoiceDetail::truncate();
        PurchaseInvoice::truncate();
        GoodsReceiptDetail::truncate();
        GoodsReceipt::truncate();
        PurchaseOrderDetail::truncate();
        PurchaseOrder::truncate();
        PurchaseRequisitionDetail::truncate();
        PurchaseRequisition::truncate();
        SalesReturnDetail::truncate();
        SalesReturn::truncate();
        SalesPayment::truncate();
        SalesInvoiceDetail::truncate();
        SalesInvoice::truncate();
        DeliveryOrderDetail::truncate();
        DeliveryOrder::truncate();
        SalesOrderDetail::truncate();
        SalesOrder::truncate();
        Product::truncate();
        Customer::truncate();
        Supplier::truncate();
        DB::table('m_user')->truncate();
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ─────────────────────────────────────────────
        // 1. USERS (auth table)
        // ─────────────────────────────────────────────
        $users = [
            ['name' => 'Admin',            'email' => 'admin@tradeflow.com',    'role' => 'admin',    'password' => Hash::make('password')],
            ['name' => 'Sales Staff',      'email' => 'sales@tradeflow.com',    'role' => 'sales',    'password' => Hash::make('password')],
            ['name' => 'Purchase Staff',   'email' => 'purchase@tradeflow.com', 'role' => 'purchase', 'password' => Hash::make('password')],
            ['name' => 'Manager',          'email' => 'manager@tradeflow.com',  'role' => 'manager',  'password' => Hash::make('password')],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, ['email_verified_at' => now()]));
        }

        // ─────────────────────────────────────────────
        // 2. M_USER (internal user reference table)
        // ─────────────────────────────────────────────
        DB::table('m_user')->insert([
            ['user_id' => 1, 'name' => 'Admin',          'role' => 'Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 2, 'name' => 'Sales Staff',    'role' => 'Sales',         'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 3, 'name' => 'Purchase Staff', 'role' => 'Purchasing',    'created_at' => now(), 'updated_at' => now()],
            ['user_id' => 4, 'name' => 'Manager',        'role' => 'Manager',       'created_at' => now(), 'updated_at' => now()],
        ]);

        // ─────────────────────────────────────────────
        // 3. MASTER DATA
        // ─────────────────────────────────────────────
        $suppliers = [
            ['name' => 'PT Supplier Elektronik', 'address' => 'Jl. Industri No. 123, Jakarta',    'phone' => '021-12345678'],
            ['name' => 'CV Mitra Jaya',           'address' => 'Jl. Perdagangan No. 45, Bandung', 'phone' => '022-87654321'],
            ['name' => 'UD Sejahtera',            'address' => 'Jl. Makmur No. 78, Surabaya',     'phone' => '031-11223344'],
        ];
        foreach ($suppliers as $data) {
            Supplier::create($data);
        }

        $customers = [
            ['name' => 'PT Maju Bersama',  'address' => 'Jl. Sudirman No. 1, Jakarta',       'phone' => '021-55556666'],
            ['name' => 'CV Sukses Selalu', 'address' => 'Jl. Gatot Subroto No. 22, Jakarta', 'phone' => '021-77778888'],
            ['name' => 'Toko Berkah',      'address' => 'Jl. Ahmad Yani No. 88, Bandung',    'phone' => '022-99990000'],
            ['name' => 'UD Lancar Jaya',   'address' => 'Jl. Pahlawan No. 55, Surabaya',     'phone' => '031-44445555'],
            ['name' => 'PT Global Trading','address' => 'Jl. Thamrin No. 99, Jakarta',       'phone' => '021-33334444'],
        ];
        foreach ($customers as $data) {
            Customer::create($data);
        }

        $products = [
            ['sku' => 'LAP-001', 'name' => 'Laptop Dell Latitude 5420',   'price' => 12500000, 'stock' => 50],
            ['sku' => 'MON-001', 'name' => 'Monitor LG 24 Inch',          'price' =>  2500000, 'stock' => 100],
            ['sku' => 'KEY-001', 'name' => 'Keyboard Logitech MX Keys',   'price' =>  1500000, 'stock' => 150],
            ['sku' => 'MOU-001', 'name' => 'Mouse Wireless Logitech',     'price' =>   350000, 'stock' => 200],
            ['sku' => 'PRT-001', 'name' => 'Printer HP LaserJet Pro',     'price' =>  4500000, 'stock' => 30],
            ['sku' => 'RTR-001', 'name' => 'Router TP-Link AC1750',       'price' =>   750000, 'stock' => 80],
            ['sku' => 'WBC-001', 'name' => 'Webcam Logitech C920',        'price' =>  1200000, 'stock' => 60],
            ['sku' => 'HDS-001', 'name' => 'Headset Gaming HyperX',       'price' =>   950000, 'stock' => 90],
            ['sku' => 'SSD-001', 'name' => 'SSD Samsung 1TB',             'price' =>  1800000, 'stock' => 120],
            ['sku' => 'RAM-001', 'name' => 'RAM DDR4 16GB Corsair',       'price' =>  1100000, 'stock' => 75],
        ];
        foreach ($products as $data) {
            Product::create($data);
        }

        // ─────────────────────────────────────────────
        // 4. SALES CYCLE
        // ─────────────────────────────────────────────

        // Sales Orders
        $so1 = SalesOrder::create([
            'so_date'      => '2026-01-15',
            'customer_id'  => 1,
            'subtotal'     => 51000000,
            'tax'          =>  5610000,
            'total_amount' => 56610000,
            'signed_by'    => 1,
            'status'       => 'Approved',
        ]);
        SalesOrderDetail::create(['so_id' => $so1->so_id, 'product_id' => 1, 'qty' => 3, 'price' => 12500000, 'discount' =>  500000, 'total_price' => 37000000]);
        SalesOrderDetail::create(['so_id' => $so1->so_id, 'product_id' => 2, 'qty' => 6, 'price' =>  2500000, 'discount' => 1000000, 'total_price' => 14000000]);

        $so2 = SalesOrder::create([
            'so_date'      => '2026-01-22',
            'customer_id'  => 2,
            'subtotal'     => 28500000,
            'tax'          =>  3135000,
            'total_amount' => 31635000,
            'signed_by'    => 2,
            'status'       => 'Approved',
        ]);
        SalesOrderDetail::create(['so_id' => $so2->so_id, 'product_id' => 5, 'qty' => 5, 'price' => 4500000, 'discount' => 500000, 'total_price' => 22000000]);
        SalesOrderDetail::create(['so_id' => $so2->so_id, 'product_id' => 6, 'qty' => 10, 'price' => 750000, 'discount' => 500000, 'total_price' =>  7000000]);

        $so3 = SalesOrder::create([
            'so_date'      => '2026-02-05',
            'customer_id'  => 3,
            'subtotal'     => 15750000,
            'tax'          =>  1732500,
            'total_amount' => 17482500,
            'signed_by'    => 2,
            'status'       => 'Draft',
        ]);
        SalesOrderDetail::create(['so_id' => $so3->so_id, 'product_id' => 3, 'qty' => 8,  'price' => 1500000, 'discount' =>  250000, 'total_price' => 11750000]);
        SalesOrderDetail::create(['so_id' => $so3->so_id, 'product_id' => 4, 'qty' => 12, 'price' =>  350000, 'discount' =>  200000, 'total_price' =>  4000000]);

        // Delivery Orders (SO1, SO2)
        $do1 = DeliveryOrder::create(['so_id' => $so1->so_id, 'do_date' => '2026-01-18', 'delivered_by' => 2]);
        foreach (SalesOrderDetail::where('so_id', $so1->so_id)->get() as $d) {
            DeliveryOrderDetail::create(['do_id' => $do1->do_id, 'product_id' => $d->product_id, 'qty_delivered' => $d->qty, 'description' => 'Delivered in good condition']);
        }

        $do2 = DeliveryOrder::create(['so_id' => $so2->so_id, 'do_date' => '2026-01-25', 'delivered_by' => 2]);
        foreach (SalesOrderDetail::where('so_id', $so2->so_id)->get() as $d) {
            DeliveryOrderDetail::create(['do_id' => $do2->do_id, 'product_id' => $d->product_id, 'qty_delivered' => $d->qty, 'description' => 'Delivered in good condition']);
        }

        // Sales Invoices (SO1 → Paid, SO2 → Unpaid)
        $si1 = SalesInvoice::create([
            'invoice_date'  => '2026-01-19',
            'due_date'      => '2026-02-18',
            'customer_id'   => $so1->customer_id,
            'so_id'         => $so1->so_id,
            'subtotal'      => $so1->subtotal,
            'tax'           => $so1->tax,
            'total_amount'  => $so1->total_amount,
            'signed_by'     => 1,
            'status'        => 'Paid',
            'payment_status'=> 'paid',
        ]);
        foreach (SalesOrderDetail::where('so_id', $so1->so_id)->get() as $d) {
            SalesInvoiceDetail::create(['sales_invoice_id' => $si1->sales_invoice_id, 'product_id' => $d->product_id, 'qty' => $d->qty, 'price' => $d->price, 'discount' => $d->discount, 'total_price' => $d->total_price]);
        }

        $si2 = SalesInvoice::create([
            'invoice_date'  => '2026-01-26',
            'due_date'      => '2026-02-25',
            'customer_id'   => $so2->customer_id,
            'so_id'         => $so2->so_id,
            'subtotal'      => $so2->subtotal,
            'tax'           => $so2->tax,
            'total_amount'  => $so2->total_amount,
            'signed_by'     => 1,
            'status'        => 'Unpaid',
            'payment_status'=> 'unpaid',
        ]);
        foreach (SalesOrderDetail::where('so_id', $so2->so_id)->get() as $d) {
            SalesInvoiceDetail::create(['sales_invoice_id' => $si2->sales_invoice_id, 'product_id' => $d->product_id, 'qty' => $d->qty, 'price' => $d->price, 'discount' => $d->discount, 'total_price' => $d->total_price]);
        }

        // Sales Payment (for SI1 - full payment)
        SalesPayment::create([
            'payment_date'      => '2026-01-30',
            'sales_invoice_id'  => $si1->sales_invoice_id,
            'amount_paid'       => $si1->total_amount,
            'received_by'       => 1,
            'paid_by'           => $so1->customer_id,
            'status'            => 'Paid',
            'payment_method'    => 'manual',
        ]);

        // Sales Return (partial return from SI1 — 1 Laptop)
        $sr1 = SalesReturn::create([
            'return_date'       => '2026-02-03',
            'sales_invoice_id'  => $si1->sales_invoice_id,
            'subtotal'          => 12000000,
            'tax'               =>  1320000,
            'total_amount'      => 13320000,
            'signed_by'         => 1,
        ]);
        SalesReturnDetail::create(['return_id' => $sr1->return_id, 'product_id' => 1, 'qty' => 1, 'price' => 12500000, 'discount' => 500000, 'total_price' => 12000000]);

        // ─────────────────────────────────────────────
        // 5. PURCHASING CYCLE
        // ─────────────────────────────────────────────

        // Purchase Requisitions
        $pr1 = PurchaseRequisition::create([
            'pr_date'       => '2026-01-05',
            'required_date' => '2026-01-20',
            'requested_by'  => 3,
            'approved_by'   => 4,
            'status'        => 'Approved',
        ]);
        PurchaseRequisitionDetail::create(['pr_id' => $pr1->pr_id, 'product_id' => 1, 'qty' => 5, 'description' => 'Restock laptop untuk kebutuhan kantor']);
        PurchaseRequisitionDetail::create(['pr_id' => $pr1->pr_id, 'product_id' => 2, 'qty' => 10,'description' => 'Restock monitor']);

        $pr2 = PurchaseRequisition::create([
            'pr_date'       => '2026-01-10',
            'required_date' => '2026-01-28',
            'requested_by'  => 3,
            'approved_by'   => 4,
            'status'        => 'Approved',
        ]);
        PurchaseRequisitionDetail::create(['pr_id' => $pr2->pr_id, 'product_id' => 5, 'qty' => 6, 'description' => 'Printer untuk departemen keuangan']);
        PurchaseRequisitionDetail::create(['pr_id' => $pr2->pr_id, 'product_id' => 6, 'qty' => 12,'description' => 'Router jaringan kantor cabang']);

        // Purchase Orders
        $po1 = PurchaseOrder::create([
            'pr_id'        => $pr1->pr_id,
            'po_date'      => '2026-01-08',
            'required_date'=> '2026-01-20',
            'supplier_id'  => 1,
            'subtotal'     => 56500000,
            'tax'          =>  6215000,
            'total_amount' => 62715000,
            'approved_by'  => 4,
            'status'       => 'Approved',
        ]);
        PurchaseOrderDetail::create(['po_id' => $po1->po_id, 'product_id' => 1, 'qty' => 5,  'price' => 11000000, 'discount' =>  500000, 'total_price' => 54500000]);
        PurchaseOrderDetail::create(['po_id' => $po1->po_id, 'product_id' => 2, 'qty' => 10, 'price' =>  2300000, 'discount' =>  300000, 'total_price' => 22000000]);

        $po2 = PurchaseOrder::create([
            'pr_id'        => $pr2->pr_id,
            'po_date'      => '2026-01-12',
            'required_date'=> '2026-01-28',
            'supplier_id'  => 2,
            'subtotal'     => 35500000,
            'tax'          =>  3905000,
            'total_amount' => 39405000,
            'approved_by'  => 4,
            'status'       => 'Approved',
        ]);
        PurchaseOrderDetail::create(['po_id' => $po2->po_id, 'product_id' => 5, 'qty' => 6,  'price' => 4000000, 'discount' =>  500000, 'total_price' => 23500000]);
        PurchaseOrderDetail::create(['po_id' => $po2->po_id, 'product_id' => 6, 'qty' => 12, 'price' =>  700000, 'discount' =>  100000, 'total_price' =>  8300000]);

        // Goods Receipts
        $gr1 = GoodsReceipt::create(['gr_date' => '2026-01-20', 'po_id' => $po1->po_id, 'received_by' => 3]);
        foreach (PurchaseOrderDetail::where('po_id', $po1->po_id)->get() as $d) {
            GoodsReceiptDetail::create(['gr_id' => $gr1->gr_id, 'product_id' => $d->product_id, 'qty_received' => $d->qty, 'item_condition' => 'Good', 'description' => 'Barang diterima dalam kondisi baik']);
        }

        $gr2 = GoodsReceipt::create(['gr_date' => '2026-01-28', 'po_id' => $po2->po_id, 'received_by' => 3]);
        foreach (PurchaseOrderDetail::where('po_id', $po2->po_id)->get() as $d) {
            GoodsReceiptDetail::create(['gr_id' => $gr2->gr_id, 'product_id' => $d->product_id, 'qty_received' => $d->qty, 'item_condition' => 'Good', 'description' => 'Barang diterima dalam kondisi baik']);
        }

        // Purchase Invoices
        $pi1 = PurchaseInvoice::create([
            'invoice_date'  => '2026-01-21',
            'due_date'      => '2026-02-20',
            'supplier_id'   => 1,
            'gr_id'         => $gr1->gr_id,
            'subtotal'      => $po1->subtotal,
            'tax'           => $po1->tax,
            'total_amount'  => $po1->total_amount,
            'signed_by'     => 1,
        ]);
        foreach (PurchaseOrderDetail::where('po_id', $po1->po_id)->get() as $d) {
            PurchaseInvoiceDetail::create(['purchase_invoice_id' => $pi1->purchase_invoice_id, 'product_id' => $d->product_id, 'qty' => $d->qty, 'price' => $d->price, 'discount' => $d->discount, 'total_price' => $d->total_price]);
        }

        $pi2 = PurchaseInvoice::create([
            'invoice_date'  => '2026-01-29',
            'due_date'      => '2026-02-28',
            'supplier_id'   => 2,
            'gr_id'         => $gr2->gr_id,
            'subtotal'      => $po2->subtotal,
            'tax'           => $po2->tax,
            'total_amount'  => $po2->total_amount,
            'signed_by'     => 1,
        ]);
        foreach (PurchaseOrderDetail::where('po_id', $po2->po_id)->get() as $d) {
            PurchaseInvoiceDetail::create(['purchase_invoice_id' => $pi2->purchase_invoice_id, 'product_id' => $d->product_id, 'qty' => $d->qty, 'price' => $d->price, 'discount' => $d->discount, 'total_price' => $d->total_price]);
        }

        // Purchase Payment (PI1 - Paid)
        PurchasePayment::create([
            'payment_date'       => '2026-02-10',
            'purchase_invoice_id'=> $pi1->purchase_invoice_id,
            'amount_paid'        => $pi1->total_amount,
            'paid_by'            => 3,
            'received_by'        => 1,
            'status'             => 'Paid',
        ]);

        // Purchase Return (partial return from PI2 — 1 Printer rusak)
        $por1 = PurchaseReturn::create([
            'return_date'        => '2026-02-05',
            'purchase_invoice_id'=> $pi2->purchase_invoice_id,
            'subtotal'           => 3500000,
            'tax'                =>  385000,
            'total_amount'       => 3885000,
            'signed_by'          => 3,
        ]);
        PurchaseReturnDetail::create(['return_id' => $por1->return_id, 'product_id' => 5, 'qty' => 1, 'price' => 4000000, 'discount' => 500000, 'total_price' => 3500000]);

        // ─────────────────────────────────────────────
        // Summary
        // ─────────────────────────────────────────────
        $this->command->info('✅ Seeder selesai!');
        $this->command->info('👤 Users       : 4 (admin, sales, purchase, manager)');
        $this->command->info('🏭 Suppliers   : 3 | 👥 Customers: 5 | 📦 Products: 10');
        $this->command->info('📋 Sales Cycle : 3 SO → 2 DO → 2 Invoice → 1 Payment → 1 Return');
        $this->command->info('🛒 Purchase    : 2 PR → 2 PO → 2 GR → 2 Invoice → 1 Payment → 1 Return');
    }
}
