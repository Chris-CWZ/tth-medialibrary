<?php

namespace App\Http\Controllers\Api\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use GuzzleHttp\Client;
use Carbon\Carbon;

class EventsController extends Controller{
    public function getEvent(Request $request){
        $events = Event::where('date', $request->date)->get();
        return $events;
    }
}
