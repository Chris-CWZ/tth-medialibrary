<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CartStock extends Pivot{

		/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'cart_id', 'stock_id', 'quantity'
	];

	public function cart(){
		return $this->belongsTo('App\Cart', 'cart_id');
	}

	public function products(){
		return $this->belongsTo('App\Stock', 'stock_id');
	}
}
