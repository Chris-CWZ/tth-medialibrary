<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\CartService;
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
		$validator = Validator::make($request->all(), [
			'userId' => 'required_without:sessionId|integer',
			'sessionId' => 'required_without:userId',
			'name' => 'required|string',
			'colour' => 'required|string',
			'size' => 'required|string',
			'quantity' => 'required|integer',
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->cartService->addToCart($request);
		}
	}

	public function removeFromCart(Request $request){
		$validator = Validator::make($request->all(), [
			'userId' => 'required_without:sessionId|integer',
			'sessionId' => 'required_without:userId',
			'productId' => 'required|integer',
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->cartService->removeFromCart($request);
		}
	}

	public function getCartProducts(Request $request){
		return $this->cartService->getCartProducts($request);
	}

	public function changeCartProduct(Request $request){
		$validator = Validator::make($request->all(), [
			'userId' => 'required_without:sessionId|integer',
			'sessionId' => 'required_without:userId',
			'productId' => 'required|integer',
			'name' => 'required|string',
			'colour' => 'required|string',
			'size' => 'required|string'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->cartService->changeCartProduct($request);
		}
	}
}
