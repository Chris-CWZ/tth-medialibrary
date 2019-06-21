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
  
  public function operatingHours() {
		$nextDate = Carbon::tomorrow('Asia/Kuala_Lumpur')->toDateString();
		$nextDay = Carbon::tomorrow('Asia/Kuala_Lumpur')->format('l');
		$nextDayEvent = Event::where('date', $nextDate)->first();
		$closedNextDay = Event::where('date', $nextDate)->where('name', 'Closed')->first();
		$followingDate = Carbon::parse($nextDate)->addDays(1)->toDateString();
		$saturdayEvent = Event::where('date', $nextDate)->first();
		$sundayEvent = Event::where('date', $followingDate)->first();

		if ($nextDay != 'Saturday' && $nextDay != 'Sunday' && !$closedNextDay){
			return respond('Open tomorrow');
		}elseif ($nextDay == 'Saturday'){
			if($saturdayEvent){
				return respond('Open tomorrow');
			}else{
				if ($sundayEvent){
					return respond('Open on Sunday');
				}else{
					return respond('Open on Monday');
				}
			}
		}elseif ($nextDay == 'Sunday'){
			if ($sundayEvent){
				return respond('Open on Sunday');
			}else{
				return respond('Open on Monday');
			}
		}else{
			return $this->nextWorkingDay($nextDate);			
		}
	}

	public function nextWorkingDay($nextDate) {
		$workingDay = false;
		$followingDate = Carbon::parse($nextDate)->addDays(1)->toDateString();

		while ($workingDay == false){
			$closedEvent = Event::where('date', $followingDate)->where('name', 'Closed')->first();
			$followingDay = Carbon::parse($followingDate)->format('l');

			if($closedEvent == null && $followingDay != 'Saturday' && $followingDay != 'Sunday'){
				$workingDay = true;
				$day = Carbon::parse($followingDate)->format('l');

				return respond(["Next open on $day, $followingDate."]);
			}else{
				$followingDate = Carbon::parse($followingDate)->addDays(1)->toDateString();
			}
		}
	}
	
	public function transform($event){
		return [
		];
	}
}
