<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model{

  protected $fillable = [
    'user_id', 'session_id', 'promo_code', 'sub_total', 'grand_total'
  ];

	// public function items(){
	// 	return $this->morphMany('App\Item', 'owner');
	// }

	public function owner(){
		return $this->belongsTo('App\User', 'user_id');
	}

	public function products(){
		return $this->belongsToMany('App\Product', 'cart_product');
	}
}
