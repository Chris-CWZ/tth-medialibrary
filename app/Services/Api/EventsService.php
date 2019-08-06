<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Event;
use App\EventUser;
use Carbon\Carbon;
use App\Services\TransformerService;

class EventsService extends TransformerService{

	/**
	* Request input: date(optional), userId 
	*/
	public function getEventByDate($request){
		if ($request->has('date')) {
            $events = Event::where('start_time', '<=', $request->date)->where('end_time', '>=', $request->date)->get();
        } else {
            $events = Event::where('date', '>=', Carbon::now()->toDateTimeString())->orderBy('start_time', 'asc')->paginate(10);
        }

        foreach ($events as $event) {
            $event = $this->isBookmarked($event, $request);
        }

        return $events;
    }
    
    public function isBookmarked($event, $request){
        $bookmarkedEvent = EventUser::where('event_id', $event->id)->where('user_id', $request->userId)->first();

        if ($bookmarkedEvent == null) {
            $event['bookmarked'] = false;
        } else {
            $event['bookmarked'] = true;
        }

        return $event;
    }

	public function nextEvent($request){
        $event = Event::where('id', '!=', $request->id)->where('start_time', '>=', $request->startTime)->orderBy('date', 'asc')->first();
		
        if ($event != null) {
            $event = $this->isBookmarked($event, $request);
            return $event;
        } else {
            return respond("No more events.");
        }
    }

    public function previousEvent($request){
        $event = Event::where('id', '!=', $request->id)->where('start_time', '<=', $request->startTime)->orderBy('date', 'desc')->first();
		
        if ($event != null) {
            $event = $this->isBookmarked($event, $request);
            return $event;
        } else {
            return respond("No more events.");
        }
    }
    
    public function transform($event){
		return [
			'id' => $event->id,
			'post_id' => $event->post_id,
			'name' => $event->name,
			'date' => $event->date,
			'start_time' => $event->start_time,
			'end_time' => $event->end_time,
			'location' => $event->location,
			'description' => $event->description,
			'fee' => $event->fee,
			'fee_amount' => $event->fee_amount,
		];
	}
}
