<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    protected $fillable = [
        'icon', 'category', 'name', 'phone_number', 'location', 'level', 'description', 'image_one', 'image_two', 'image_three', 'location_image', 'website'
    ];
}
