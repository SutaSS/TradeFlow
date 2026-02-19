<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequisitionDetail extends Model
{
    protected $table = 'purchase_requisition_detail';
    protected $primaryKey = 'pr_detail_id';
    protected $fillable = [
        'pr_id',
        'product_id',
        'qty',
        'description',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class, 'pr_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}