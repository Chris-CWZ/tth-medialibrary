<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql2';

    protected $fillable = [
        'name', 'price', 'category', 'colour', 'size', 'product_code', 'product_details', 'brand', 'care', 'vendor', 'stock'
    ];

    public function cartItem(){
        return $this->hasMany('App\CartItem', 'cart_id');
    }
}
