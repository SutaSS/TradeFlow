<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryOrder extends Model
{
    protected $table = 'delivery_order';
    protected $primaryKey = 'do_id';
    protected $fillable = [
        'so_id',
        'do_date',
        'delivered_by',
    ];

    protected $casts = [
        'do_date' => 'date',
    ];

    public function salesOrder(): BelongsTo
    {
        return $this->belongsTo(SalesOrder::class, 'so_id');
    }

    public function deliveredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delivered_by');
    }

    public function details(): HasMany
    {
        return $this->hasMany(DeliveryOrderDetail::class, 'do_id');
    }
}