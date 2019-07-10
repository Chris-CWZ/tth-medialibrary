<?php

namespace App\Services;

use App\CartProduct;
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

		$duplicateCartProduct = CartProduct::where('id', $cart->id)->where('product_id', $productId)->first();
		
		if ($duplicateCartProduct == null) {
			$cartItem = CartProduct::create([
				'cart_id' => $cart->id,
				'product_id' => $productId,
				'quantity' => $quantity
			]);
		} else {
			CartProduct::where('id', $cart->id)->where('product_id', $productId)->increment('quantity', $quantity);
		}

		return success("Item added");
	}

	public function transform($item){
		return [
		];
	}
}
