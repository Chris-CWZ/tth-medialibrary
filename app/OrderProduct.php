<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $fillable = [
		'order_id', 'product_id', 'quantity'
	];

    public function order(){
		return $this->belongsTo('App\Order', 'order_id');
	}

    public function product(){
		return $this->belongsTo('App\Product', 'product_id');
	}
}
