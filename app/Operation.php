<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'id', 'date', 'start_time', 'end_time',
    ];
}
