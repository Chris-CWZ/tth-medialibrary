<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Cart;
use App\Promotion;
use App\Services\TransformerService;
use App\Services\Api\CartProductService;
use App\Services\Api\PromotionsService;
use App\Services\Api\ProductsService;

class CartService extends TransformerService{

	protected $cartProductService;
	protected $promotionsService;

	public function __construct(CartProductService $cartProductService, PromotionsService $promotionsService, ProductsService $productsService){
		$this->cartProductService = $cartProductService;
		$this->promotionsService = $promotionsService;
		$this->productsService = $productsService;
	}

	/**
	*
	*	Add item to cart for existing users
	*	Request input for user/add-product: userId, name, colour, size, quantity
	*	Request input for guest/add-product: sessionId, name, colour, size, quantity
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
		}

		$product = $this->cartProductService->addProduct($cart, $request);

		if($product == null) {
			return errorResponse('Item is out of stock');
		} else {
			$cart->sub_total += $product->price * $request->quantity;

			if($cart->promo_code == null) {
				$cart->grand_total = $cart->sub_total;
			} else {
				$promotion = Promotion::where('code', $cart->promo_code)->first();
				$cartTotal = $this->promotionsService->calculateDiscount($cart, $promotion);
				$cart->grand_total = $cartTotal;
			}

			$cart->save();
			return success('Item added to cart');
		}
	}

	public function removeFromCart($request){
		if ($request->has('userId')) {
			$cart = $this->getCart("user", $request->input('userId'));
		} else {
			$cart = $this->getCart("session", $request->input('sessionId'));
		}

		$product = $this->productsService->retrieveProduct($request->productId);

		if ($request->has('quantity')) {
			$response = $this->cartProductService->reduceQuantity($request, $cart, $product);
		}else{
			$response = $this->cartProductService->removeFromCart($request, $cart, $product);
		}

		// Check if promo code still applicable after removal
		if($cart->promo_code != null) {
			$promotion = Promotion::where('code', $cart->promo_code)->first();
			$result = $this->promotionsService->checkCartRequirement($promotion, $cart);

			if($result->status() == 200) {
				$cart->grand_total = $this->promotionsService->calculateDiscount($cart, $promotion);
			} else {
				// Remove promo code from cart
				$cart->promo_code = null;
				$cart->grand_total = $cart->sub_total;
			}
		} else {
			$cart->grand_total = $cart->sub_total;
		}

		$cart->save();

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
			$cart = $this->mergeCarts($request);
			$cartProductsArray = $this->cartProductService->getCartProducts($cart);
		} else if ($request->has('userId') && !($request->has('sessionId'))) {
			$cart = $this->getCart("user", $request->input('userId'));

			if ($cart == null) {
				$cart = $this->createCart($request);
				return success("Cart is empty.");
			} else {
				$cartProductsArray = $this->cartProductService->getCartProducts($cart);
			}
		} else if ($request->has('sessionId') && !($request->has('userId'))){
			$cart = $this->getCart("session", $request->input('sessionId'));

			if ($cart == null) {
				$cart = $this->createCart($request);
				return success("Cart is empty.");
			} else {
				$cartProductsArray = $this->cartProductService->getCartProducts($cart);
			}
		}

		// Checks if promo code is still valid
		$promotion = $this->promotionsService->checkValidity($cart->promo_code);

		if($promotion == null) {
			$cart->promo_code = null;
			$cart->grand_total = $cart->sub_total;
			$cart->save();
		}

		return ['sub_total' => $cart->sub_total, 'promo_code' => $cart->promo_code, 'grand_total' => $cart->grand_total, 'cart' => $cartProductsArray];
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
