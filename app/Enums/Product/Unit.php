<?php

namespace App\Enums\Product;

enum Unit:string
{
    case KG = 'kg';
    case Gram = 'gm';
    case LITRE = 'litre';
    case ML = 'ml';
    case PIECE = 'piece';
    case BUNDLE = 'bundle';
    case PACKET = 'packet';
}
