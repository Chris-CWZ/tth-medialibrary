<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql2';

    protected $fillable = [
        'name', 
        'price', 
        'category', 
        'product_details', 
        'brand', 
        'care', 
        'vendor'
    ];
}
