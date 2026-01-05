<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $appends = ['product_image'];
    public function getProductImageAttribute()
    {
        if(!$this->image){
            return url('asset/no-image.jpg');
        }
        $image=$this->image;
        if(file_exists('storage/'.$image)){
            return url('storage/'.$image);
        }else{
            return url('asset/no-image.jpg');
        }
    }
}
