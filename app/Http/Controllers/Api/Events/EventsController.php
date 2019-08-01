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
        $userId = $request ->userId;
            foreach ($events as $event) {
                $isBookmarked = EventUser::where('userID', $userId)->get();
                return $events->withBookmarked($isBookmarked);
                # code...
            }
            return $events;
    }
}
