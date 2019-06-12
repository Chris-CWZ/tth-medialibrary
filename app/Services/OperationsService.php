<?php

namespace App\Services;

use App\Operation;
use App\Event;
use Carbon\Carbon;
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
		$currentDate = date(Carbon::today('Asia/Kuala_Lumpur')->toDateString());
		$nextDate = date(Carbon::tomorrow('Asia/Kuala_Lumpur')->toDateString());
		$currentDay = Carbon::today('Asia/Kuala_Lumpur')->format('l');
		$nextDay = Carbon::tomorrow('Asia/Kuala_Lumpur')->format('l');
		$nextDayEvent = Event::where('date', $nextDate)->first();
		$closedNextDay = Event::where('date', $nextDate)->where('name', 'Closed')->first();

		if ($closedNextDay){
			return $this->nextWorkingDay($nextDate);			
		}else{
			return respond('Open tomorrow');
		}
	}

	public function nextWorkingDay($nextDate) {
		$workingDay = false;
		$nextDate = strtotime($nextDate);
		$followingDate = date('Y-m-d', strtotime("+1 day", $nextDate));
		
		while ($workingDay == false){
			$closedEvent = Event::where('date', $followingDate)->where('name', 'Closed')->first();

			if($closedEvent == null){
				$workingDay = true;
				$day = date('l', strtotime($followingDate));

				return respond(["Next open on $day, $followingDate."]);
			}else{
				$followingDate = date('Y-m-d', strtotime("+1 day", strtotime($followingDate)));
			}
		}
	}
	
	public function transform($event){
		return [
		];
	}
}
