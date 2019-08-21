<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\StocksService;

class StocksController extends Controller {
	protected $stocksService;

	public function __construct(StocksService $stocksService){
		$this->stocksService = $stocksService;
	}

	public function colours(Request $request){
		$validator = Validator::make($request->all(), [
			'productId' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->stocksService->colours($request);
		}
	}

	public function sizes(Request $request){
		$validator = Validator::make($request->all(), [
			'productId' => 'required|integer',
			'colour' => 'required|string'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->stocksService->sizes($request);
		}
	}
}
