<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'code', 'type', 'start_date', 'expiry_date', 'discount_percentage', 'discount_amount', 'cap_amount', 'min_spending', 'usage_limit'
    ];
}
