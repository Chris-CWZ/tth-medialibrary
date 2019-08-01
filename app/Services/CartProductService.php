<?php

namespace App\Services;

use App\CartProduct;
use Illuminate\Http\Request;
use App\Services\TransformerService;
use App\Services\ProductsService;

class CartProductService extends TransformerService{

	protected $productsService;

	public function __construct(ProductsService $productsService){
		$this->productsService = $productsService;
	}

	/**
	*
	*	Creates a new entry depending on whether an existing entry exists
	*	Request input: user_id, product_id, quantity
	*
	**/
	public function addProduct($cart, $request){
		$productCode = $request->input('productCode');
		$quantity = $request->input('quantity');
		$duplicateCartProduct = CartProduct::where('cart_id', $cart->id)->where('product_code', $productCode)->first();

		if ($duplicateCartProduct == null) {
			CartProduct::create([
				'cart_id' => $cart->id,
				'product_code' => $productCode,
				'quantity' => $quantity
			]);
		} else {
			CartProduct::where('cart_id', $cart->id)->where('product_code', $productCode)->increment('quantity', $quantity);
		}

		return success("Item added to cart");
	}

	/**
	*
	*	Retrieve products' details in cart
	*	Request input: user_id or session_id
	*
	**/
	public function getCartProducts($cart){
		// Get all cart items using cart Id
		$cartId = $cart->id;
		$cartProducts = CartProduct::where('cart_id', $cartId)->get();

		// Getting product details using product Id
		if ($cartProducts->isEmpty()) {
			return success("Cart is empty");
		} else {
			foreach($cartProducts as $cartProduct){
				$product = $this->productsService->retrieveProduct($cartProduct);
				$productDetails['quantity'] = $cartProduct['quantity'];
				$productDetails['product'] = $product;
				$cartProductsArray[] = $productDetails;
			}

			return $cartProductsArray;
		}
	}

	/**
	*
	*	Update cart ID
	*
	**/
	public function updateCartId($userCart, $sessionCart){
		CartProduct::where('cart_id', $sessionCart['id'])->update(['cart_id' => $userCart['id']]);
	}

	/**
	*
	*	Retrieve all cart products related to a cart ID
	*
	**/
	public function retrieveCartProducts($cart){
		$cartProducts = CartProduct::where('cart_id', $cart->id)->get();
		return $cartProducts;
	}

	/**
	*
	*	Retrieve first cart product using cart product id
	*
	**/
	public function retrieveSingleProduct($cartProduct){
		$cartProduct = CartProduct::where('id', $cartProduct->id)->first();
		return $cartProduct;
	}

	/**
	*
	*	Retrieve duplicated cart product entry
	*	(Those with the same cart_id & product_code)
	*
	**/
	public function getDuplicateCartProduct($cartProduct){
		$duplicatedCartProduct = CartProduct::where('cart_id', $cartProduct['cart_id'])->where('product_code', $cartProduct['product_code'])->where('id', '!=', $cartProduct->id)->first();
		return $duplicatedCartProduct;
	}

	/**
	*
	*	Increase quantity of a cart product id
	*
	**/
	public function mergeQuantity($originalCartProduct, $duplicatedCartProduct){
		CartProduct::where('id', $originalCartProduct->id)->increment('quantity', (int)$duplicatedCartProduct['quantity']);
	}


	public function reduceQuantity($request, $cart){
		$cartProduct = CartProduct::where('cart_id', $cart->id)->where('product_code', $request->productCode)->first();

		if($cartProduct->quantity != 1){
			$cartProduct::decrement('quantity', $request->quantity);

			return success("1 item has been removed from cart");
		}else{
			return $this->removeFromCart($request, $cart);
		}
	}
	/**
	*
	*	Delete entry using cart product id
	*
	**/
	public function delete($cartProduct){
		CartProduct::where('id', $cartProduct->id)->delete();
	}

	public function removeFromCart($request, $cart){
		CartProduct::where('cart_id', $cart->id)->where('product_code', $request->productCode)->delete();

		return success("Item removed from cart!");
	}

	public function transform($cartProduct){
		return [
			'id' => $cartProduct->id,
		];
	}
}
