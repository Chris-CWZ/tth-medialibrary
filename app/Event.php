<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['post_id', 'name', 'date', 'start_time', 'end_time', 'location', 'description', 'fee', 'fee_amount'];
}
