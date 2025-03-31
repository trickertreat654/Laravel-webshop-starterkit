<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stripe_checkout_session_id',
        'payment_id',
        'amount_shipping',
        'amount_discount',
        'amount_tax',
        'amount_subtotal',
        'amount_total',
        'billing_address',
        'shipping_address',
        'status',
        'total',
    ];

    public $casts = [
        'billing_address' => 'collection',
        'shipping_address' => 'collection',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
