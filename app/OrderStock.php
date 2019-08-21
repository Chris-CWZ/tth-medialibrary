<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderStock extends Pivot
{
	protected $connection = 'mysql';

    protected $fillable = [
		'order_id', 'stock_id', 'quantity'
	];
}
