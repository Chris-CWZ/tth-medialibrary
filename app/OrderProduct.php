<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
	protected $connection = 'mysql';

    protected $fillable = [
		'order_id', 'product_id', 'quantity'
	];
}
