<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'name',
        'description',
        'price',
        'amount_discount',
        'amount_tax',
        'amount_subtotal',
        'amount_total',
    ];

    public function product(): BelongsTo 
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
