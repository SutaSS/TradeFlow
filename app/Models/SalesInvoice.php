<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesInvoice extends Model
{
    protected $table = 'sales_invoice';
    protected $primaryKey = 'sales_invoice_id';
    protected $fillable = [
        'invoice_date',
        'due_date',
        'customer_id',
        'so_id',
        'subtotal',
        'tax',
        'total_amount',
        'signed_by',
        'status',
        'xendit_invoice_id',
        'payment_status',
        'payment_url',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'so_id');
    }

    public function signedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SalesInvoiceDetail::class, 'sales_invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SalesPayment::class, 'sales_invoice_id');
    }

    public function returns(): HasMany
    {
        return $this->hasMany(SalesReturn::class, 'sales_invoice_id');
    }

    public function totalPaid()
    {
        return $this->payments()->where('status', 'success')->sum('amount_paid');
    }

    public function markAsPaid()
    {
        if ($this->totalPaid() >= $this->total_amount) {
            $this->update(['status' => 'Paid']);
        }
    }
}