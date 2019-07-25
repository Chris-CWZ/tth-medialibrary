<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductUser extends Pivot
{
    public function products() {
        return $this->belongsTo('App\Product');
    }
}
