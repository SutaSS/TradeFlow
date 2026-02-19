<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    // ...existing code...
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relations - Sales
    public function salesOrdersCreated(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'signed_by');
    }

    public function salesInvoicesCreated(): HasMany
    {
        return $this->hasMany(SalesInvoice::class, 'signed_by');
    }

    public function salesPaymentsReceived(): HasMany
    {
        return $this->hasMany(SalesPayment::class, 'received_by');
    }

    public function salesReturnsCreated(): HasMany
    {
        return $this->hasMany(SalesReturn::class, 'signed_by');
    }

    public function deliveryOrdersCreated(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class, 'delivered_by');
    }

    // Relations - Purchase
    public function purchaseRequisitionsRequested(): HasMany
    {
        return $this->hasMany(PurchaseRequisition::class, 'requested_by');
    }

    public function purchaseRequisitionsApproved(): HasMany
    {
        return $this->hasMany(PurchaseRequisition::class, 'approved_by');
    }

    public function purchaseOrdersApproved(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'approved_by');
    }

    public function goodsReceiptsCreated(): HasMany
    {
        return $this->hasMany(GoodsReceipt::class, 'received_by');
    }

    public function purchaseInvoicesCreated(): HasMany
    {
        return $this->hasMany(PurchaseInvoice::class, 'signed_by');
    }

    public function purchasePaymentsMade(): HasMany
    {
        return $this->hasMany(PurchasePayment::class, 'paid_by');
    }

    public function purchaseReturnsCreated(): HasMany
    {
        return $this->hasMany(PurchaseReturn::class, 'signed_by');
    }
}