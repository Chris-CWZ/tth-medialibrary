<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model{

  protected $fillable = [
    'user_id'
  ];

	public function items(){
		return $this->morphMany('App\Item', 'owner');
	}

	public function owner(){
		return $this->belongsTo('App\User', 'user_id');
	}
}
