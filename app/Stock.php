<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $connection = 'mysql2';

    protected $fillable = [
        'product_id',
        'colour',
        'size',
        'product_code',
        'stock'
    ];

    public function product(){
		return $this->belongsTo('App\Product');
	}
}
