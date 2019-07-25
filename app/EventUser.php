<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    public function events() {
        return $this->belongsTo('App\Event');
    }
}
