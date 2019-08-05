<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
	
	protected $fillable = [
		'user_id', 'session_id', 'transaction_id', 'amount', 'status'
	];

	public function user(){
		return $this->belongsTo('App\User', 'user_id');
	}
}
