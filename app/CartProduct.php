<?php

namespace App;

use Illuminate\Database\Eloquent\Pivot;

class CartProduct extends Pivot{

		/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'cart_id', 'product_id', 'quantity'
	];

	public function cart(){
		return $this->belongsTo('App\Cart', 'cart_id');
	}

	public function product(){
		return $this->belongsTo('App\Product', 'product_id');
	}
}
