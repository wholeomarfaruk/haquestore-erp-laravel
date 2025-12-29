<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $table = 'invoices';
    protected $fillable = [
        'customer_id',
        'user_id',
        'invoice_id',
        'invoice_date',
        'due_date',
        'total',
        'discount',
        'grand_total',
        'paid_amount',
        'due_amount',
        'status',
        'delivery_status',
        'payment_status',
        'note',
        'json_data',
        'previous_due',
    ];

    // Define relationship with InvoiceItem model
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transections()
    {
        return $this->hasMany(Transection::class);
    }

}
