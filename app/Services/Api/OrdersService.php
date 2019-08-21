<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Order;
use App\OrderStock;
use App\User;
use App\UserPromotion;
use App\Stock;
use App\CartStock;
use App\Services\TransformerService;
use App\Services\Api\CartService;
use App\Services\Api\CartStockService;
use Session;


class OrdersService extends TransformerService{
	protected $cartService;
	protected $cartStockService;

	public function __construct(CartService $cartService, CartStockService $cartStockService){
		$this->cartService = $cartService;
		$this->cartStockService = $cartStockService;
	}

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

		// Get cart stocks using user's/guest's cart ID
		$cartStocks = CartStock::where('cart_id', $cart->id)->get();

		// Add each product to order product table and remove from cart product table
		foreach($cartStocks as $cartStock) {
			$orderStock = OrderStock::create([
				'order_id' => $order->id,
				'stock_id' => $cartStock->stock_id,
				'quantity' => $cartStock->quantity
			]);

			// Minus stock
			Stock::where('id', $cartStock->stock_id)->decrement('stock', $cartStock->quantity);

			$cartStock->delete();
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
