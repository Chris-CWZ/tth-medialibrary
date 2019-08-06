<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventUser;

class EventsController extends Controller{

	public function getEventByDate(Request $request){
		$events = Event::where('date', $request->date)->get();

		foreach ($events as $event) {
			$bookmarked = EventUser::where('event_id', $event->id)->where('user_id', $request->userId)->first();
			
			if($bookmarked){
				$event['bookmarked'] = true;
			}else{
				$event['bookmarked'] = false;
			}
		}

		return $events;
	}
}
