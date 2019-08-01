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
			$bookmarked = EventUser::where('event_id', $event->id)->get();
			
			if($bookmarked){
				$event['bookmarked'] = true;
			}
		}

		return $events;
	}
}
