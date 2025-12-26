<?php

namespace App\Enums\Product;

enum StockStatus:string
{
    case IN_STOCK = 'in_stock';
    case STOCK_OUT = 'stock_out';
    case LOW_STOCK = 'low_stock';
}
