<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Cart;
use App\Product;
use App\Stock;
use App\Promotion;
use App\CartStock;
use App\Services\TransformerService;
use App\Services\Api\CartStockService;
use App\Services\Api\PromotionsService;
use App\Services\Api\ProductsService;

class CartService extends TransformerService{

	protected $cartStockService;
	protected $promotionsService;
	protected $productsService;

	public function __construct(CartStockService $cartStockService, PromotionsService $promotionsService, ProductsService $productsService){
		$this->cartStockService = $cartStockService;
		$this->promotionsService = $promotionsService;
		$this->productsService = $productsService;
	}

	public function addToCart($request){
		if ($request->has('userId')) {
			$cart = $this->getCart("user", $request->input('userId'));
		} else {
			$cart = $this->getCart("session", $request->input('sessionId'));
		}

		if ($cart == null) {
			$cart = $this->createCart($request);
		}

		$stock = $this->cartStockService->addStock($cart, $request);

		if($stock == null) {
			return errorResponse('Item is out of stock');
		}

		$product = Product::find($stock->product_id);

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

	public function removeFromCart($request){
		if ($request->has('userId')) {
			$cart = $this->getCart("user", $request->input('userId'));
		} else {
			$cart = $this->getCart("session", $request->input('sessionId'));
		}

		$product = Stock::find($request->stockId)->product;

		if ($request->has('quantity')) {
			$response = $this->cartStockService->reduceQuantity($request, $cart, $product);
		}else{
			$response = $this->cartStockService->removeFromCart($request, $cart, $product);
		}

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

	public function getCartProducts($request){
		// If user has both user and session id, then combine both carts
		if ($request->has('userId') && $request->has('sessionId')) {
			$cart = $this->mergeCarts($request);
		} else if ($request->has('userId') && !($request->has('sessionId'))) {
			$cart = $this->getCart("user", $request->userId);
		} else if ($request->has('sessionId') && !($request->has('userId'))){
			$cart = $this->getCart("session", $request->sessionId);
		}

		if(!$cart) {
			$cart = $this->createCart($request);
		}

		$cartProductsArray = $this->cartStockService->getCartStocks($cart);

		// Checks if promo code is still valid
		if($cart->promo_code) {
			$promotion = $this->promotionsService->checkValidity($cart->promo_code);

			if(!$promotion) {
				$cart->promo_code = null;
				$cart->grand_total = $cart->sub_total;
				$cart->save();
			}
		}

		return ['sub_total' => $cart->sub_total, 'promo_code' => $cart->promo_code, 'grand_total' => $cart->grand_total, 'cart' => $cartProductsArray];
	}

	public function mergeCarts($request){
		// Get cart id of session id
		$sessionCart = $this->getCart("session", $request->input('sessionId'));

		// Get cart id of user id
		$userCart = $this->getCart("user", $request->input('userId'));

		if(!$sessionCart) {
			return $userCart;
		}

		// If there is no cart associated with user id
		if ($userCart == null) {
			$userCart = $this->createCart($request);
		}

		// Update user's new cart total with session ID's cart total
		$userCart->sub_total += $sessionCart->sub_total;
		$userCart->grand_total = $userCart->sub_total;
		$userCart->save();

		// Change cart id of all session cart products
		CartStock::where('cart_id', $sessionCart->id)->update(['cart_id' => $userCart->id]);

		// Delete cart of session id
		$sessionCart->delete();

		// Get all new cart products of user's cart
		$userCartStocks = CartStock::where('cart_id', $userCart->id)->get();

		// Delete cart products that share the same product code and increment
		foreach($userCartStocks as $userCartStock) {
			// Checking if the entry still exist (might be deleted from previous loop)
			$cartStock = CartStock::find($userCartStock->id);

			if ($cartStock == null) {
				continue;
			} else {
				// Get duplicate entry
				$duplicatedCartStock = CartStock::where('cart_id', $userCartStock->cart_id)->where('stock_id', $userCartStock->stock_id)->where('id', '!=', $userCartStock->id)->first();

				if ($duplicatedCartStock != null) {
					// Increase quantity of original entry
					CartStock::where('id', $userCartStock->id)->increment('quantity', $duplicatedCartStock->quantity);

					// Delete duplicated cart product entry
					CartStock::where('id', $duplicatedCartStock->id)->delete();
				}
			}
		}

		return $userCart;
	}

	public function changeCartProduct($request){
		if($request->has('userId')) {
			$cart = $this->getCart("user", $request->input('userId'));
		} else {
			$cart = $this->getCart("session", $request->input('sessionId'));
		}

		// Get stock ID of new item
		$stock = Stock::where('product_id', $request->productId)->where('colour', $request->colour)->where('size', $request->size)->first();

		if($stock == null) {
			return errorResponse("Product is out of stock");
		}

		// Get cart stock of new stock ID if it exists
		$newCartStock = CartStock::where('cart_id', $cart->id)->where('stock_id', $stock->id)->first();

		// Get cart stock to be changed
		$oldCartStock = CartStock::where('cart_id', $cart->id)->where('stock_id', $request->stockId)->first();
		
		// Change stock ID in cart stocks table
		if($newCartStock == null) {
			$oldCartStock->stock_id = $stock->id;
			$oldCartStock->save();
		} else {
			$newCartStock->quantity += $oldCartStock->quantity;
			$newCartStock->save();
			$oldCartStock->delete();
		}
		
		return success("Successfully changed item");
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
