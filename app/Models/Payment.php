<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'payment_id','product_name','quantity','amount',
        'currency','payer_name','payer_email','payment_status','payment_method','response',
        'transaction_id','paid_at','order_id','user_id','status','ip_address','user_agent','notes',
        'shipping_address','billing_address','custom_field','discount_code','coupon_code','referral_code'
    ];

    
    protected $casts = [
        'status' => PaymentStatus::class, // هذا هو الربط الحقيقي
    ];

    // In app/Models/Payment.php
    public function items()
    {
        return $this->hasMany(PaymentItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to get formatted order number
    public function getOrderNumberAttribute()
    {
        return 'ORD-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
