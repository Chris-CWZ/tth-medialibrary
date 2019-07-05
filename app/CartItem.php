<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model{

	/**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'cart_id', 'product_id', 'product_type', 'grouped_with_id', 'price', 'inscription'
  ];


	public function cart(){
		return $this->belongsTo('App\Cart');
	}

	public function product(){
		return $this->morphTo();
	}

	public function groupedWith(){
		return $this->belongsTo('App\CartItem', 'grouped_with_id');
	}

	public function isGroupedWith(){
		return $this->hasOne('App\CartItem', 'grouped_with_id');
	}

	public function variants(){
		return $this->morphMany('App\ItemVariant', 'parent');
	}
}
