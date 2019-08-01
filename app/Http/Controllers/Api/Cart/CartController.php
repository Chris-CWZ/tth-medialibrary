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
		$validator = Validator::make($request->all(), [
			'userId' => 'required_without:sessionId|integer',
			'sessionId' => 'required_without:userId|integer',
			'productCode' => 'required',
			'quantity' => 'required|integer',
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->cartService->addToCart($request);
		}
	}

	public function removeFromCart(Request $request){
		return $this->cartService->removeFromCart($request);
	}

	public function getCartProducts(Request $request){
		return $this->cartService->getCartProducts($request);
	}
}
