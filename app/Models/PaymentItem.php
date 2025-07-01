<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
        protected $fillable = [
        'payment_id',
        'product_name',
        'quantity',
        'price',
        'total'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
