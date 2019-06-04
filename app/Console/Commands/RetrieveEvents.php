<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Event;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Carbon\Carbon;

class RetrieveEvents extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'retrieve:events';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Retrieving events from wordpress api';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->eventsService = $eventsService;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle(){
		$client = new Client();
		$response = $client->get('http://trp-wpapi.tth.asia/wp-json/wp/v2/event');
		$responseBody = json_decode($response->getBody());

		foreach ($responseBody as $event) {
			$feeAmount = (double) $event->acf->fee_amount;
			$existingEvent = Event::where('post_id', $event->id)->first();
			$date = $event->acf->event_date ? Carbon::createFromFormat('d/m/Y', $event->acf->event_date)->format('Y/m/d') : null;
			$startTime = $event->acf->event_start_time ? Carbon::createFromFormat('g:i a', $event->acf->event_start_time)->format('H:i:s') : null;
			$endTime = $event->acf->event_end_time ? Carbon::createFromFormat('g:i a', $event->acf->event_end_time)->format('H:i:s') : null;
			$dateStartTime = strtotime($date . ' ' . $startTime);
			$dateEndTime = strtotime($date . ' ' . $endTime);

			if(!$existingEvent){
				$newEvent = new Event;
				$newEvent->post_id = $event->id;
				$newEvent->name = $event->acf->event_name;
				$newEvent->date = $date;
				$newEvent->start_time = date('Y-m-d H:i:s', $dateStartTime);
				$newEvent->end_time =  date('Y-m-d H:i:s', $dateEndTime);
				$newEvent->location = $event->acf->event_location;
				$newEvent->description = $event->acf->description;
				$newEvent->fee = $event->acf->fee;
				$newEvent->fee_amount = $feeAmount;
				$newEvent->save();
			}else{
				$existingEvent->name = $event->acf->event_name;
				$existingEvent->date = $date;
				$existingEvent->start_time =  date('Y-m-d H:i:s', $dateStartTime);
				$existingEvent->end_time =  date('Y-m-d H:i:s', $dateEndTime);
				$existingEvent->location = $event->acf->event_location;
				$existingEvent->description = $event->acf->description;
				$existingEvent->fee = $event->acf->fee;
				$existingEvent->fee_amount = $feeAmount;
				$existingEvent->save();
			}
		}
	}
}
