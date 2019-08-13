<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectoryImage extends Model
{
    protected $fillable = [
        'directory_id', 'banner_image'
    ];

    public function directory(){
        return $this->belongsTo('App\Directory', 'directory_id');
    }
}
