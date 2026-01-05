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
   protected $appends = ['profile_picture'];
    public function getProfilePictureAttribute()
    {
        if(!$this->image){
            return url('asset/avatar.png');
        }
        $image=$this->image;
        if(file_exists('storage/'.$image)){
            return url('storage/'.$image);
        }else{
            return url('asset/avatar.png');
        }
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
