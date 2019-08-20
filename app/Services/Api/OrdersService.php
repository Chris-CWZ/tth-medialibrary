<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Order;
use App\OrderProduct;
use App\User;
use App\UserPromotion;
use App\Product;
use App\Services\TransformerService;
use App\Services\Api\CartService;
use App\Services\Api\CartProductService;
use App\Services\Api\ProductsService;
use Session;


class OrdersService extends TransformerService{
	protected $path = 'admin.orders.';
	protected $cartService;
	protected $cartProductService;
	protected $productsService;

	public function __construct(CartService $cartService, CartProductService $cartProductService, ProductsService $productsService){
		$this->cartService = $cartService;
		$this->cartProductService = $cartProductService;
		$this->productsService = $productsService;
	}

	/**
	*
	*	Create order after user pays
	*	Request input: userId, transactionId, amount
	*
	**/
	public function createOrder($request){
		if ($request->has('userId')) {
			// Gets cart ID of user
			$cart = $this->cartService->getCart('user', $request->userId);

			// Add to user promotion table after successfully checked out with promo code
			if($cart->promo_code != null) {
				UserPromotion::create([
					'user_id' => $request->userId,
					'promo_code' => $cart->promo_code
				]);
			}
		} else {
			// Gets cart ID of guest
			$cart = $this->cartService->getCart('guest', $request->sessionId);
		}

		// Creates a new order entry for either guest or user
		$order = Order::create([
			'user_id' => $request->userId,
			'session_id' => $request->sessionId,
			'transaction_id' => $request->transactionId,
			'sub_total' => $cart->sub_total,
			'grand_total' => $cart->grand_total,
			'status' => 'processing',
			'promo_code' => $cart->promo_code
		]);

		// Edit cart details after checkout
		$cart->promo_code = null;
		$cart->sub_total = 0.00;
		$cart->grand_total = 0.00;
		$cart->save();

		// Get cart products using user's/guest's cart ID
		$cartProducts = $this->cartProductService->retrieveCartProducts($cart);

		// Add each product to order product table and remove from cart product table
		foreach($cartProducts as $cartProduct) {
			$orderProduct = OrderProduct::create([
				'order_id' => $order->id,
				'product_id' => $cartProduct->product_id,
				'quantity' => $cartProduct->quantity
			]);

			$this->cartProductService->delete($cartProduct);

			// Minus stock
			Product::where('id', $cartProduct->product_id)->decrement('stock', $cartProduct->quantity);
		}

		return success("Order created");
	}

	/**
	*
	*	Get all user's orders
	*	Request input: userId
	*
	**/
	public function getUserOrders($request){
		$orders = Order::where('user_id', $request->userId)->get();

		// Note: depends on the app if they only want orders or product orders as well
		foreach($orders as $order) {
			$orderProducts = OrderProduct::where('order_id', $order->id)->get();

			foreach($orderProducts as $orderProduct) {
				$products[] = $this->productsService->retrieveProduct($orderProduct->id);
			}

			$order['items'] = $products;
			$ordersList[] = $order;

			// Clearing the products array after appending it to order array
			$products = array();
		}

		return $ordersList;
	}

	public function getAddresses(Request $request){
		$user = new User;

		$user = User::on('mysql3')->find(62);

		return $user;
	}

	public function transform($order){
		return [
			'id' => $order->id,
			'user_id' => $order->user_id,
			'transaction_id' => $order->transaction_id,
			'amount' => $order->amount,
			'status' => $order->status,
			'promo_code' => $order->promo_code
		];
	}
}
