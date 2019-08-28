<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $connection = 'mysql3';

    protected $fillable = [
        'first_name',
        'last_name', 
        'phone_number', 
        'line_one', 
        'line_two', 
        'state', 
        'city',
        'postcode', 
        'country',
        'user_id', 
        'default_delivery_address', 
        'default_billing_address'
    ];
}
