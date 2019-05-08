<?php

/**
 * Team Services That handle all the business logic releated to the team members in one place
 */

namespace App\Services;

use App\Event;
use Illuminate\Http\Request;

class TeamServices extends TransformerService{

	public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'created_at';
    $order = $request->order ? $request->order : 'desc';
    $limit = $request->limit ? $request->limit : 10;
    $offset = $request->offset ? $request->offset : 0;
    $query = $request->search ? $request->search : '';

    $events = Event::where('id', '!=', current_user()->id)->where('role', 1)->where('name', 'like', "%{$query}%")->orderBy($sort, $order);
    $listCount = $events->count();

    $events = $events->limit($limit)->offset($offset)->get();

    return respond(['rows' => $events, 'total' => $listCount]);
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
