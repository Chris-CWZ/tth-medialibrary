<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Operations;
use App\Services\OperationsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperationsController extends Controller{

	protected $operationsService;
	protected $path='admin.calendar.';

	public function __construct(OperationsService $operationsService){
		$this->operationsService = $operationsService;
	}
	

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// public function calender(Request $request){
	// 	return $this->operationsService->index($request);
	// }

	public function calendar() {
		$events = Event::get();
		$events = [];
		foreach($events as $key => $event){
			$events[]=[
				"id" => $event->id,
				"title" => $event->name,
				"start" =>$event->start_time,
				"end" =>$event->end_time,
				"description"=>'Click to go to edit page'
			];
		}
		//dd($events);
		return view($this->path . 'calendar', ['events' => $events]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Operations  $operations
	 * @return \Illuminate\Http\Response
	 */
	public function show(Operations $operations){
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Operations  $operations
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Operations $operations){
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Operations  $operations
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Operations $operations){
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Operations  $operations
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Operations $operations){
		//
	}
}
