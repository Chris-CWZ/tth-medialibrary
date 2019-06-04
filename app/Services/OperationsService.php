<?php

namespace App\Services;

use App\Operation;
use App\Event;
use Session;
use Illuminate\Http\Request;

class OperationsService extends TransformerService{
	
  protected $path = 'admin.calendar.';  
  
  public function calendar() {
		$allEvents = Event::get();

		foreach($allEvents as $event){
			$events[]=[
				"id" => $event['id'],
				"title" => $event['name'],
				"start" =>$event['start_time'],
				"end" =>$event['end_time'],
			];
		}

		return view($this->path . 'calendar', ['events' => $events]);
  }
  
  public function operatingHours() {

  }

	public function transform($event){
		return [
		];
	}
}
