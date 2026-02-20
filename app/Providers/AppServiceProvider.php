<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

// Models
use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use App\Models\SalesInvoice;
use App\Models\SalesPayment;
use App\Models\SalesReturn;
use App\Models\DeliveryOrder;
use App\Models\PurchaseRequisition;
use App\Models\PurchaseOrder;
use App\Models\GoodsReceipt;
use App\Models\PurchaseInvoice;
use App\Models\PurchasePayment;
use App\Models\PurchaseReturn;

// Policies
use App\Policies\CustomerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\SalesOrderPolicy;
use App\Policies\SalesInvoicePolicy;
use App\Policies\SalesPaymentPolicy;
use App\Policies\SalesReturnPolicy;
use App\Policies\DeliveryOrderPolicy;
use App\Policies\PurchaseRequisitionPolicy;
use App\Policies\PurchaseOrderPolicy;
use App\Policies\GoodsReceiptPolicy;
use App\Policies\PurchaseInvoicePolicy;
use App\Policies\PurchasePaymentPolicy;
use App\Policies\PurchaseReturnPolicy;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Master Data
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);

        // Sales Module
        Gate::policy(SalesOrder::class, SalesOrderPolicy::class);
        Gate::policy(SalesInvoice::class, SalesInvoicePolicy::class);
        Gate::policy(SalesPayment::class, SalesPaymentPolicy::class);
        Gate::policy(SalesReturn::class, SalesReturnPolicy::class);
        Gate::policy(DeliveryOrder::class, DeliveryOrderPolicy::class);

        // Purchase Module
        Gate::policy(PurchaseRequisition::class, PurchaseRequisitionPolicy::class);
        Gate::policy(PurchaseOrder::class, PurchaseOrderPolicy::class);
        Gate::policy(GoodsReceipt::class, GoodsReceiptPolicy::class);
        Gate::policy(PurchaseInvoice::class, PurchaseInvoicePolicy::class);
        Gate::policy(PurchasePayment::class, PurchasePaymentPolicy::class);
        Gate::policy(PurchaseReturn::class, PurchaseReturnPolicy::class);
    }
}