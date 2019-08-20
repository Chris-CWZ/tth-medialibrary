<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\Cast\Bool_;
use Illuminate\Support\Facades\Validator;
use App\Services\Api\EventsService;

class EventsController extends Controller{
	protected $eventsService;

	public function __construct(EventsService $eventsService){
    	$this->eventsService = $eventsService;
	}

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
			return $this->eventsService->getEventByDate($request);
		}
	}

	public function nextEvent(Request $request){
		$validator = Validator::make($request->all(), [
            'userId' => 'integer',
			'startTime' => 'required|date_format:Y-m-d H:i:s',
			'id' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->eventsService->nextEvent($request);
		}
	}

	public function previousEvent(Request $request){
		$validator = Validator::make($request->all(), [
            'userId' => 'integer',
			'startTime' => 'required|date_format:Y-m-d H:i:s',
			'id' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->eventsService->previousEvent($request);
		}
	}

	public function getEventsByMonth(Request $request){
        $validator = Validator::make($request->all(), [
            'month' => 'integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->eventsService->getEventsByMonth($request);
		}
    }
}
