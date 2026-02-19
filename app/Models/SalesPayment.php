<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesPayment extends Model
{
    protected $table = 'sales_payment';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'payment_date',
        'sales_invoice_id',
        'amount_paid',
        'received_by',
        'paid_by',
        'payment_method',
        'external_id',
        'reference_id',
        'payment_channel',
        'gateway_status',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function salesInvoice(): BelongsTo
    {
        return $this->belongsTo(SalesInvoice::class, 'sales_invoice_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'paid_by');
    }
}