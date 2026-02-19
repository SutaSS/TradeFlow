<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasePayment extends Model
{
    protected $table = 'purchase_payment';
    protected $primaryKey = 'payment_id';
    protected $fillable = [
        'payment_date',
        'purchase_invoice_id',
        'amount_paid',
        'paid_by',
        'received_by',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'decimal:2',
    ];

    public function purchaseInvoice(): BelongsTo
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'received_by');
    }
}