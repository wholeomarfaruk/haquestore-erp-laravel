<?php

namespace App\Enums\Invoice;

enum PaymentStatus:string
{
    case PAID = 'paid';
    case PARTIAL = 'partial';
    case UNPAID = 'unpaid';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
}

