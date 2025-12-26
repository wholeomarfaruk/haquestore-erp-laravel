<?php

namespace App\Enums\Invoice;

enum DeliveryStatus:string
{
    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case DELIVERED = 'delivered';
    case PARTIAL_DELIVERED = 'partial_delivered';
    case RETURNED = 'returned';
}
           
