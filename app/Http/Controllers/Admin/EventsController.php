<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Services\EventsService;
use Illuminate\Http\Request;
use DB;

class EventsController extends Controller{
	protected $path = 'admin.events.';
	protected $eventsService;

	public function __construct(EventsService $eventsService){
    $this->eventsService = $eventsService;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		return $this->eventsService->index($request);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Event  $event
	 * @return \Illuminate\Http\Response
	 */
	public function show(Event $event){
		return $this->eventsService->show($event);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Event  $event
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Event $event){
		return view($this->path . 'edit', ['event' => $event]);		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Event  $event
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Event $event){
		return $this->eventsService->update($request, $event);		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Event  $event
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Event $event){
		$event->delete();

		return success('Event successfully deleted');
	}
}
