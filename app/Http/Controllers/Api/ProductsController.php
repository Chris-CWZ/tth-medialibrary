<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\ProductsService;

class ProductsController extends Controller {
	protected $productsService;

	public function __construct(ProductsService $productsService){
		$this->productsService = $productsService;
	}
	
	/**
	*
	*	Retrieve products
	*	Optional request input: sort, order, filter, min, max
	*
	**/
	public function retrieveProductsList(Request $request){
		$validator = Validator::make($request->all(), [
			'sort' => 'required_with:order|string',
			'order' => 'required_with:sort|string',
			'filter' => 'string',
			'min' => 'required_with:filter|numeric',
			'max' => 'required_with:filter|numeric',
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->productsService->retrieveProductsList($request);
		}
	}

	public function colours(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->productsService->colours($request);
		}
	}

	public function sizes(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->productsService->sizes($request);
		}
	}
}
