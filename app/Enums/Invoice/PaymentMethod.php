<?php

namespace App\Enums\Invoice;

enum PaymentMethod:string
{
    case CASH = 'cash';
    case CARD = 'card';
    case CHEQUE = 'cheque';
    case BKASH = 'bkash';
    case NAGAD = 'nagad';
    case ROCKET = 'rocket';
    case BALANCE = 'balance';
}
