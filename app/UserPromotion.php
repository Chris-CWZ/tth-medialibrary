<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPromotion extends Model
{
    protected $fillable = [
        'user_id', 'promo_code'
    ];
}
