<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseReturn extends Model
{
    protected $table = 'purchase_return';
    protected $primaryKey = 'return_id';
    protected $fillable = [
        'return_date',
        'purchase_invoice_id',
        'subtotal',
        'tax',
        'total_amount',
        'signed_by',
    ];

    protected $casts = [
        'return_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function purchaseInvoice(): BelongsTo
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    public function signedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseReturnDetail::class, 'return_id');
    }
}