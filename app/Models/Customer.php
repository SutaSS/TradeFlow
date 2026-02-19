<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'm_customer';
    protected $primaryKey = 'customer_id';
    protected $fillable = [
        'name',
        'address',
        'phone',
    ];

    public function salesOrders(): HasMany
    {
        return $this->hasMany(SalesOrder::class, 'customer_id');
    }

    public function salesInvoices(): HasMany
    {
        return $this->hasMany(SalesInvoice::class, 'customer_id');
    }

    public function salesPayments(): HasMany
    {
        return $this->hasMany(SalesPayment::class, 'paid_by');
    }
}