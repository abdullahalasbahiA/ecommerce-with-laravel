<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'payment_id',
        'product_name',
        'quantity',
        'amount',
        'currency',
        'payer_name',
        'payer_email',
        'payment_status',
        'payment_method',
        'response',
        'transaction_id',
        'paid_at',
        'order_id',
        'user_id',
        'status',
        'ip_address',
        'user_agent',
        'notes',
        'shipping_address',
        'billing_address',
        'custom_field',
        'discount_code',
        'coupon_code',
        'referral_code'
    ];

    // In app/Models/Payment.php
    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }
}
