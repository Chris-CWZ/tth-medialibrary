<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Product;
use App\ProductUser;
use App\Event;
use App\EventUser;
use App\Services\Api\ProductsService;
use App\Services\Admin\EventsService;
use App\Services\TransformerService;


class BookmarksService {

	protected $productsService;

	public function __construct(ProductsService $productsService, EventsService $eventsService){
        $this->productsService = $productsService;
        $this->eventsService = $eventsService;
	}

	public function getBookmarkedProducts($request){
		$bookmarks = [];

		$productUsers = ProductUser::where('user_id', $request->userId)->get();

		foreach ($productUsers as $productUser) {
			$product = $this->productsService->transform($productUser->product);

			array_push($bookmarks, $product);
		}

		return $bookmarks;
	}

	public function productBookmark(Request $request){
		$existingProductUser = ProductUser::where('product_id', $request->productId)->where('user_id', $request->userId)->first();

		if(!$existingProductUser){
			$productUser = new ProductUser;
			$productUser->product_id = $request->productId;
			$productUser->user_id = $request->userId;
			$productUser->save();

			return success('Bookmark added for product');
		}else{
			$existingProductUser->delete();

			return success('Bookmark removed for product');
		}
	}

	public function eventBookmark(Request $request){
		// create many-to-many relationship table for users and specific event
		$event = Event::where('id', $request->id)->first();
		$existingEventUser = EventUser::where('event_id',$event->id)->where('user_id',$request->userId)->first();

		if($existingEventUser){
			$existingEventUser->delete();
			return success('Bookmark removed for event');
		}else{
			$eventUser = new EventUser;
			$eventUser->event_id= $event->id;
			$eventUser->user_id = $request->userId;
			$eventUser->save();
			return success('Bookmark added for event');
		}
	}

	public function getBookmarkedEvents($request){
		$bookmarks = [];
		$eventUsers = EventUser::where('user_id', $request->userId)->get();

		foreach ($eventUsers as $eventUser) {
			$event = $this->eventsService->transform($eventUser->event);
			array_push($bookmarks, $event);
		}
		return $bookmarks;
	}
}
