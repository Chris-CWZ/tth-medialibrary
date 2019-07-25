<?php

namespace App\Http\Controllers\Api\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller {
	protected $productService;

	public function __construct(ProductService $productService){
		$this->productService = $productService;
	}
	
	/**
	*
	*	Retrieve products
	*	Optional request input: sort, order, filter, min, max
	*
	**/
	public function index(Request $request){
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
			return $this->productService->retrieveProductsList($request);
		}
	}

	public function colours(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->productService->colours($request);
		}
	}

	public function sizes(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => 'required|string'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->productService->sizes($request);
		}
	}

	public function bookmark(Request $request){
		$validator = Validator::make($request->all(), [
			'productCode' => 'required|integer',
			'userId' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->productService->bookmark($request);
		}
	}
}
