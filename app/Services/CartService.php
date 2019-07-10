<?php

namespace App\Services;

use App\Cart;
use App\CartProduct;
use App\Product;
use App\Services\TransformerService;
use App\Services\CartProductService;
use Illuminate\Http\Request;

class CartService extends TransformerService{

	protected $cartProductService;

	public function __construct(CartProductService $cartProductService){
		$this->cartProductService = $cartProductService;
	}

	/**
	*
	*	Add item to cart for existing users
	*	Request input: user_id, product_id, quantity
	*
	**/
	public function addToCart($request){
		$cart = $this->getCartId($request);

		if ($cart == null) {
			$cart = $this->createCart($request);
			$response = $this->cartProductService->isProductExist($cart, $request);
			return $response;
		} else {
			$response = $this->cartProductService->isProductExist($cart, $request);
			return $response;
		}
	}

	public function getCartId($request){
		if ($request->has('user_id')) {
			$cart = Cart::where('user_id', $request->input('user_id'))->first();
			return $cart;
		} else {
			$cart = Cart::where('session_id', $request->input('session_id'))->first();
			return $cart;
		}
	}

	public function createCart($request){
		if ($request->has('user_id')) {
			$cart = Cart::create([
				'user_id' => $request->input('user_id')
			]);
	
			return $cart;
		} else {
			$cart = Cart::create([
				'session_id' => $request->input('session_id')
			]);
	
			return $cart;
		}
	}

	/**
	*
	*	Retrieve products' details in cart
	*	Request input: user_id or session_id
	*
	**/
	public function getCartProducts($request){
		// Check if user has existing cart
		$cart = $this->getCartId($request);

		if ($cart == null) {
			$cart = $this->createCart($request);
			$cartProductsArray = $this->cartProductService->getCartProducts($cart, $request);
			return $cartProductsArray;
		} else {
			$cartProductsArray = $this->cartProductService->getCartProducts($cart, $request);
			return $cartProductsArray;
		}
	}

	public function transform($cart){
		return [
			'id' => $cart->id,
			'user_id' => $cart->user_id,
			'session_id' => $cart->session_id,
			'products' => $cart->product
		];
	}
}
