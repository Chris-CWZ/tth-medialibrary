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
	*	Request input for user/add-product: userId, productCode, quantity
	*	Request input for guest/add-product: sessionId, productCode, quantity
	*
	**/
	public function addToCart($request){
		if ($request->has('userId')) {
			$cart = $this->getCart("user", $request->input('userId'));
		} else {
			$cart = $this->getCart("session", $request->input('sessionId'));
		}

		if ($cart == null) {
			$cart = $this->createCart($request);
			$response = $this->cartProductService->isProductExist($cart, $request);
			return $response;
		} else {
			$response = $this->cartProductService->isProductExist($cart, $request);
			return $response;
		}
	}
	
	public function removeFromCart($request){
		if ($request->has('userId')) {
			$cart = $this->getCart("user", $request->input('userId'));
		} else {
			$cart = $this->getCart("session", $request->input('sessionId'));
		}

		if ($request->has('quantity')) {
			$response = $this->cartProductService->reduceQuantity($request, $cart);		
		}else{
			$response = $this->cartProductService->removeFromCart($request, $cart);
		}

		return $response;
	}

	public function getCart($idType, $id){
		if ($idType == "user") {
			$cart = Cart::where('user_id', $id)->first();
			return $cart;
		} else {
			$cart = Cart::where('session_id', $id)->first();
			return $cart;
		}
	}

	public function createCart($request){
		if ($request->has('userId')) {
			$cart = Cart::create([
				'user_id' => $request->input('userId')
			]);
	
			return $cart;
		} else {
			$cart = Cart::create([
				'session_id' => $request->input('sessionId')
			]);
	
			return $cart;
		}
	}

	/**
	*
	*	Retrieve products' details in cart
	*	Request input for guest/cart: sessionId
	*	Request input for user/cart: userId or userId and sessionId
	*
	**/
	public function getCartProducts($request){
		// If user has both user and session id, then combine both carts
		if ($request->has('userId') && $request->has('sessionId')) {
			$userCart = $this->mergeCarts($request);
			$cartProductsArray = $this->cartProductService->getCartProducts($userCart);
			return respond($cartProductsArray);
		} else if ($request->has('userId') && !($request->has('sessionId'))) {
			$cart = $this->getCart("user", $request->input('userId'));

			if ($cart == null) {
				$cart = $this->createCart($request);
				return success("Cart is empty.");
			} else {
				$cartProductsArray = $this->cartProductService->getCartProducts($cart);
				return respond($cartProductsArray);
			}
		} else if ($request->has('sessionId') && !($request->has('userId'))){
			$cart = $this->getCart("session", $request->input('sessionId'));

			if ($cart == null) {
				$cart = $this->createCart($request);
				return success("Cart is empty.");
			} else {
				$cartProductsArray = $this->cartProductService->getCartProducts($cart);
				return respond($cartProductsArray);
			}
		}
	}

	/**
	*
	*	Combine guest cart with user's existing cart
	*
	**/
	public function mergeCarts($request){
		// Get cart id of session id
		$sessionCart = $this->getCart("session", $request->input('sessionId'));

		// Get cart id of user id
		$userCart = $this->getCart("user", $request->input('userId'));

		// If there is no cart associated with user id
		if ($userCart == null) {
			$userCart = $this->createCart($request);
		}

		// Change cart id of all session cart products
		$this->cartProductService->updateCartId($userCart, $sessionCart);

		// Delete cart of session id
		$this->delete($sessionCart);

		// Get all new cart products of user's cart
		$newCartProducts = $this->cartProductService->retrieveCartProducts($userCart);

		// Delete cart products that share the same product code and increment
		foreach($newCartProducts as $newCartProduct) {
			// Checking is the entry still exist (might be deleted from previous loop)
			$cartProduct = $this->cartProductService->retrieveSingleProduct($newCartProduct);

			if ($cartProduct == null) {
				continue;
			} else {
				// Get duplicate entry
				$duplicatedCartProduct = $this->cartProductService->getDuplicateCartProduct($newCartProduct);
				
				if ($duplicatedCartProduct != null) {
					// Increase quantity of original entry
					$this->cartProductService->mergeQuantity($newCartProduct, $duplicatedCartProduct);

					// Delete duplicated cart product entry
					$this->cartProductService->delete($duplicatedCartProduct);
				}
			}
		}

		return $userCart;
	}

	/**
	*
	*	Delete cart
	*
	**/
	public function delete($cart){
		Cart::where('id', $cart['id'])->delete();
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
