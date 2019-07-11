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
	*	Request input: user_id/session_id, product_id, quantity
	*
	**/
	public function addToCart($request){
		if ($request->has('user_id')) {
			$cart = $this->getCart("user", $request->input('user_id'));
		} else {
			$cart = $this->getCart("session", $request->input('session_id'));
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
		// If user has both user and session id, then combine both carts
		if ($request->has('user_id') && $request->has('session_id')) {
			// Get cart id of session id
			$sessionCart = $this->getCart("session", $request->input('session_id'));

			// Get cart id of user id
			$userCart = $this->getCart("user", $request->input('user_id'));
	
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

			// Delete cart products that share the same product id and increment
			foreach($newCartProducts as $newCartProduct) {
				// Checking is the entry still exist (might be deleted from previous loop)
				$cartProduct = $this->cartProductService->retrieveSingleProduct($newCartProduct);

				if ($cartProduct == null) {
					continue;
				} else {
					// Get duplicate entry
					$duplicatedCartProduct = $this->cartProductService->getDuplicateCardProduct($newCartProduct);
					
					// Increase quantity of original entry
					$this->cartProductService->increaseQuantity($newCartProduct, $duplicatedCartProduct);

					// Delete duplicated cart product entry
					$this->cartProductService->delete($duplicatedCartProduct);
				}
			}

			$cartProductsArray = $this->cartProductService->getCartProducts($userCart);
			return $cartProductsArray;
		} else if ($request->has('user_id') && !($request->has('session_id'))) {
			$cart = $this->getCart("user", $request->input('user_id'));

			if ($cart == null) {
				$cart = $this->createCart($request);
				return success("Cart is empty.");
			} else {
				$cartProductsArray = $this->cartProductService->getCartProducts($cart);
				return $cartProductsArray;
			}
		} else if ($request->has('session_id') && !($request->has('user_id'))){
			$cart = $this->getCart("session", $request->input('session_id'));

			if ($cart == null) {
				$cart = $this->createCart($request);
				return success("Cart is empty.");
			} else {
				$cartProductsArray = $this->cartProductService->getCartProducts($cart);
				return $cartProductsArray;
			}
		}
	}

	/**
	*
	*	Delete cart
	*
	**/
	public function delete($cart){
		Cart::where('id', $cart->id)->delete();
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
