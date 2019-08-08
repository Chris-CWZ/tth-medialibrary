<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Operation;
use App\Event;
use App\Services\TransformerService;


class OperationsService extends TransformerService{

  protected $path = 'admin.calendar.';

  public function calendar() {
		$allEvents = Event::get();

		if(count($allEvents) > 0){
			foreach($allEvents as $event){
				$events[]=[
					"id" => $event['id'],
					"title" => $event['name'],
					"start" =>$event['start_time'],
					"end" =>$event['end_time'],
				];
			}
		}else{
			$events= null;
		}
		return view($this->path . 'calendar', ['events' => $events]);
  }

	public function transform($event){
		return [
		];
	}
}
