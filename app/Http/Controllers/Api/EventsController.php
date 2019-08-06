<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\EventUser;
use PhpParser\Node\Expr\Cast\Bool_;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller{

	/**
	 * Request input: date(optional), userId 
	 */
	public function getEventByDate(Request $request){
		$validator = Validator::make($request->all(), [
			'userId' => 'integer',
			'date' => 'date_format:Y-m-d'
		]);
		
		if ($validator->fails()) {
			return validationError();
		} else {
			if ($request->has('date')) {
				$events = Event::where('start_time', '<=', $request->date)->where('end_time', '>=', $request->date)->get();
			} else {
				$events = Event::where('date', '>=', Carbon::now()->toDateTimeString())->paginate(10);
			}
	
			foreach ($events as $event) {
				$bookmarkedEvent = EventUser::where('event_id', $event->id)->where('user_id', $request->userId)->first();
	
				if ($bookmarkedEvent == null) {
					$event['bookmarked'] = false;
				} else {
					$event['bookmarked'] = true;
				}
			}
	
			return $events;
		}
	}

	public function nextEvent(Request $request){
		$validator = Validator::make($request->all(), [
            'userId' => 'integer',
			'date' => 'required|date_format:Y-m-d',
			'id' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			$event = Event::where('id', '!=', $request->id)->where('date', '>=', $request->date)->orderBy('date', 'asc')->first();
		
			if ($event == null) {
				
			}

			$bookmarkedEvent = EventUser::where('event_id', $event->id)->where('user_id', $request->userId)->first();
	
			if ($bookmarkedEvent == null) {
				$event['bookmarked'] = false;
			} else {
				$event['bookmarked'] = true;				
			}

			return $event;
		}
	}
}
