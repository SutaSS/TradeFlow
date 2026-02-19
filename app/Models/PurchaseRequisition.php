<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequisition extends Model
{
    protected $table = 'purchase_requisition';
    protected $primaryKey = 'pr_id';
    protected $fillable = [
        'pr_date',
        'required_date',
        'requested_by',
        'approved_by',
        'status',
    ];

    protected $casts = [
        'pr_date' => 'date',
        'required_date' => 'date',
    ];

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionDetail::class, 'pr_id');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class, 'pr_id');
    }
}