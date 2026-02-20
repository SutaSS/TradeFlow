<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoodsReceiptDetail extends Model
{
    protected $table = 'goods_receipt_detail';
    protected $primaryKey = 'gr_detail_id';
    protected $fillable = [
        'gr_id',
        'product_id',
        'qty_received',
        'item_condition',
        'description',
    ];

    protected $casts = [
        'qty_received' => 'integer',
    ];

    public function goodsReceipt(): BelongsTo
    {
        return $this->belongsTo(GoodsReceipt::class, 'gr_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}