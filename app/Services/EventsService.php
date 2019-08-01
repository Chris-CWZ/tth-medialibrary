<?php

namespace App\Services;

use App\Event;
use Session;
use Illuminate\Http\Request;

class EventsService extends TransformerService{

  protected $path = 'admin.events.';

	public function all(Request $request){
		$sort = $request->sort ? $request->sort : 'created_at';
    $order = $request->order ? $request->order : 'desc';
    $limit = $request->limit ? $request->limit : 10;
    $offset = $request->offset ? $request->offset : 0;
    $query = $request->search ? $request->search : '';

    $events = Event::where('name', 'like', "%{$query}%")->orderBy($sort, $order);
    $listCount = $events->count();

    $events = $events->limit($limit)->offset($offset)->get();

    return respond(['rows' => $events, 'total' => $listCount]);
	}

	public function index(Request $request){
    if ($request->wantsJson()) {
      return $this->all($request);
    }else{
      return view($this->path . 'index');
    }
	}

	public function show($event){
    $event = $this->transform($event);
    return view($this->path . 'show', ['event' => $event]);
	}

	public function update($request, $event){
		$event->name = $request->name;
		$event->date = $request->date;
		$event->start_time = $request->start_time;
		$event->end_time = $request->end_time;
		$event->location = $request->location;
		$event->description = $request->description;
		$event->fee = $request->fee;
		$event->fee_amount = $request->fee_amount;
		$event->save();

		Session::flash('success', 'The event was successfully saved!');
    return redirect()->route($this->path . 'index');
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
