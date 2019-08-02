<?php

namespace App\Http\Controllers\Api\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventUser;
use PhpParser\Node\Expr\Cast\Bool_;

class EventsController extends Controller{

        public function getEventByDate(Request $request){
            $events = Event::where('date', $request->date)->get();
            foreach ($events as $event) {
                $CheckBookmark = EventUser::where('event_id', $event->id)->first();
                if($CheckBookmark){
                    $event['Bookmarked'] = True;
                }
            }
            return $events;
        }
    }
