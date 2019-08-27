<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    protected $fillable = [
        'icon', 'category', 'name', 'phone_number', 'location', 'level', 'description', 'location_image', 'website'
    ];

    public function getImageAttribute(){
        return $this->icon;
    }

    public function banners(){
        return $this->hasMany('App\DirectoryImage');
    }
}
