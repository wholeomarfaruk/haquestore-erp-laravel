<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transection extends Model
{
     protected $table = 'transections';
    protected $fillable = [
        'amount',
        'type',
        'status',
        'notes',
        'customer_id',
        'before_balance',
        'after_balance',
        'user_id',
        'invoice_id',
        'payment_method',
    ];


    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    protected $casts = [
        'amount' => 'float',
    ];
}
