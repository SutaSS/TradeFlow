<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryOrderDetail extends Model
{
    protected $table = 'delivery_order_detail';
    protected $primaryKey = 'do_detail_id';
    protected $fillable = [
        'do_id',
        'product_id',
        'qty_delivered',
        'description',
    ];

    protected $casts = [
        'qty_delivered' => 'integer',
    ];

    public function deliveryOrder(): BelongsTo
    {
        return $this->belongsTo(DeliveryOrder::class, 'do_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}