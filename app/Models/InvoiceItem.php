<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = 'invoice_items';
    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_name',
        'unit_name',
        'unit_qty',
        'regular_price',
        'discount_price',
        'purchase_price',
        'discount_amount',
        'price_after_adjustment',
        'is_price_adjusted',
        'total',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
