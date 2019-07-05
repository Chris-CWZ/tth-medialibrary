<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model{
	
	protected $fillable = [
		'user_id', 'product_code', 'quantity'
	];

	public function user(){
		return $this->belongsTo('App\User');
	}
}
