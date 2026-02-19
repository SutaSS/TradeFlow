<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $table = 'm_product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'sku',
        'name',
        'price',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function salesOrderDetails(): HasMany
    {
        return $this->hasMany(SalesOrderDetail::class, 'product_id');
    }

    public function salesInvoiceDetails(): HasMany
    {
        return $this->hasMany(SalesInvoiceDetail::class, 'product_id');
    }

    public function salesReturnDetails(): HasMany
    {
        return $this->hasMany(SalesReturnDetail::class, 'product_id');
    }

    public function deliveryOrderDetails(): HasMany
    {
        return $this->hasMany(DeliveryOrderDetail::class, 'product_id');
    }

    public function purchaseRequisitionDetails(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionDetail::class, 'product_id');
    }

    public function purchaseOrderDetails(): HasMany
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'product_id');
    }

    public function goodsReceiptDetails(): HasMany
    {
        return $this->hasMany(GoodsReceiptDetail::class, 'product_id');
    }

    public function purchaseInvoiceDetails(): HasMany
    {
        return $this->hasMany(PurchaseInvoiceDetail::class, 'product_id');
    }

    public function purchaseReturnDetails(): HasMany
    {
        return $this->hasMany(PurchaseReturnDetail::class, 'product_id');
    }
}