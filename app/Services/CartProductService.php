<?php

namespace App\Services;

use App\CartProduct;
use Illuminate\Http\Request;
use App\Services\TransformerService;
use App\Services\ProductService;

class CartProductService extends TransformerService{

	protected $productService;

	public function __construct(ProductService $productService){
		$this->productService = $productService;
	}

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
	public function getCartProducts($cart){
		// Get all cart items using cart Id
		$cartId = $cart->id;
		$cartProducts = CartProduct::where('cart_id', $cartId)->get();

		// Getting product details using product Id
		if ($cartProducts->isEmpty()) {
			return success("Cart is empty");
		} else {
			foreach($cartProducts as $cartProduct){
				$product = $this->productService->retrieveProduct($cartProduct);
				$productDetails['name'] = $product['name'];
				$productDetails['price'] = $product['price'];
				$productDetails['category'] = $product['category'];
				$productDetails['colour'] = $product['colour'];
				$productDetails['size'] = $product['size'];
				$productDetails['quantity'] = $cartProduct['quantity'];
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
	*	(Those with the same cart_id & product_id)
	*
	**/
	public function getDuplicateCardProduct($cartProduct){
		$duplicatedCartProduct = CartProduct::where('cart_id', $cartProduct['cart_id'])->where('product_id', $cartProduct['product_id'])->where('id', '!=', $cartProduct->id)->first();
		return $duplicatedCartProduct;
	}

	/**
	*
	*	Increase quantity of a cart product id
	*
	**/
	public function increaseQuantity($originalCartProduct, $duplicatedCartProduct){
		CartProduct::where('id', $originalCartProduct->id)->increment('quantity', (int)$duplicatedCartProduct['quantity']);
	}

	/**
	*
	*	Delete entry using cart product id
	*
	**/
	public function delete($cartProduct){
		CartProduct::where('id', $cartProduct['id'])->delete();
	}

	public function transform($cartProduct){
		return [
			'id' => $cartProduct->id,
		];
	}
}
