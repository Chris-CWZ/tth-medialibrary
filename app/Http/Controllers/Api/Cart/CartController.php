<?php

namespace App\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller{

	protected $cartService;

	public function __construct(CartService $cartService){
		$this->cartService = $cartService;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function addToCart(Request $request){
		if ($request->path() == "api/user/add-product") {
			$validator = Validator::make($request->all(), [
				'userId' => 'required|integer',
				'productCode' => 'required',
				'quantity' => 'required|integer',
			]);
		} else {
			$validator = Validator::make($request->all(), [
				'sessionId' => 'required',
				'productCode' => 'required',
				'quantity' => 'required|integer',
			]);
		}

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->cartService->addToCart($request);
		}
	}

	public function getCartProducts(Request $request){
		if ($request->path() == "api/user/cart") {
			$validator = Validator::make($request->all(), [
				'userId' => 'required'
			]);
		} else {
			$validator = Validator::make($request->all(), [
				'sessionId' => 'required'
			]);
		}
		
		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->cartService->getCartProducts($request);
		}
	}
}
