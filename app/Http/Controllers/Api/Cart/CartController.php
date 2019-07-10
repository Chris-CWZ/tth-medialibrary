<?php

namespace App\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartService;

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
	// public function index(Request $request){
	// 	return $this->cartService->cart('json');
	// }

	public function addToUserCart(Request $request){
		return $this->cartService->addToUserCart($request);
	}

	public function addToGuestCart(Request $request){
		return $this->cartService->addToGuestCart($request);
	}

	public function getCartProducts(Request $request){
		return $this->cartService->getCartProducts($request);
	}
}
