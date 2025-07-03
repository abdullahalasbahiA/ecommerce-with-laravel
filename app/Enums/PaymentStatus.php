<?php

// <!-- app/Enums/PaymentStatus.php -->

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING    = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED  = 'completed';
    case FAILED     = 'failed';
    case CANCELLED  = 'cancelled';
    case REFUNDED   = 'refunded';

    public function label(): string
    {
        return match($this) {
            self::PENDING    => 'Pending',
            self::PROCESSING => 'Processing',
            self::COMPLETED  => 'Completed',
            self::FAILED     => 'Failed',
            self::CANCELLED  => 'Cancelled',
            self::REFUNDED   => 'Refunded',
        };
    }

    public function colorClass(): string
    {
        return match($this) {
            self::PENDING    => 'bg-yellow-100 text-yellow-800',
            self::PROCESSING => 'bg-blue-100 text-blue-800',
            self::COMPLETED  => 'bg-green-100 text-green-800',
            self::FAILED     => 'bg-red-100 text-red-800',
            self::CANCELLED  => 'bg-gray-200 text-gray-800',
            self::REFUNDED   => 'bg-purple-100 text-purple-800',
        };
    }
}
