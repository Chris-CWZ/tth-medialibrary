<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BundledProductPromotion extends Model
{
    protected $fillable = [
        'promotion_id', 'product_id'
    ];
}
