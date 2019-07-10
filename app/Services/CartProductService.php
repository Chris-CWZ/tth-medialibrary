<?php

namespace App\Services;

use App\CartProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Services\TransformerService;

class CartProductService extends TransformerService{

	/**
	*
	*	Creates a new entry depending on whether an existing entry exists
	*	Request input: user_id, product_id, quantity
	*
	**/
	public function isProductExist($cart, $request){
		$productId = $request->input('product_id');
		$quantity = $request->input('quantity');

		$duplicateCartProduct = CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->first();
		
		if ($duplicateCartProduct == null) {
			CartProduct::create([
				'cart_id' => $cart->id,
				'product_id' => $productId,
				'quantity' => $quantity
			]);
		} else {
			CartProduct::where('cart_id', $cart->id)->where('product_id', $productId)->increment('quantity', $quantity);
		}

		return success("Item added");
	}

	/**
	*
	*	Retrieve products' details in cart
	*	Request input: user_id or session_id
	*
	**/
	public function getCartProducts($cart, $request){
		// Get all cart items using cart Id
		$cartId = $cart->id;
		$cartProducts = CartProduct::where('cart_id', $cartId)->get();

		// Getting product details using product Id
		if ($cartProducts->isEmpty()) {
			return success("Cart is empty");
		} else {
			foreach($cartProducts as $key=>$cartProduct){
				$product[] = Product::where('id', $cartProduct['product_id'])->get();
				$productDetails['name'] = $product[$key][0]['name'];
				$productDetails['price'] = $product[$key][0]['price'];
				$productDetails['category'] = $product[$key][0]['category'];
				$productDetails['colour'] = $product[$key][0]['colour'];
				$productDetails['size'] = $product[$key][0]['size'];
				$productDetails['quantity'] = $cartProduct['quantity'];
				$cartProductsArray[] = $productDetails;
			}

			return $cartProductsArray;
		}
	}

	public function transform($item){
		return [
		];
	}
}
