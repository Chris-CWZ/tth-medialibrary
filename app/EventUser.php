<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    public function event() {
        return $this->belongsTo('App\Event');
    }
}
