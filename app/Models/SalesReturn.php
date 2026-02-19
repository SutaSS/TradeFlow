<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesReturn extends Model
{
    protected $table = 'sales_return';
    protected $primaryKey = 'return_id';
    protected $fillable = [
        'return_date',
        'sales_invoice_id',
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

    public function salesInvoice(): BelongsTo
    {
        return $this->belongsTo(SalesInvoice::class, 'sales_invoice_id');
    }

    public function signedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(SalesReturnDetail::class, 'return_id');
    }
}