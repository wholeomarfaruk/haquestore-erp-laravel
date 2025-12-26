<?php

namespace App\Enums\Invoice;

enum Status:string
{
    case DRAFT = 'draft';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case DUE = 'due';
    case OVERDUE = 'overdue';
}
