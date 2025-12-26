<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'phone',
        'second_phone',
        'email',
        'balance',
        'status',
        'address',
        'image',
        'note',
        'json_data',
    ];
}
