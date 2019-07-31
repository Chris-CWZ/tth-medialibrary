<?php

namespace App\Services;

use App\Order;
use App\OrderProduct;
use App\CartProduct;
use App\Services\TransformerService;
use App\Services\CartService;
use App\Services\CartProductService;
use Illuminate\Http\Request;

class OrdersService extends TransformerService{

    protected $cartService;
    protected $cartProductService;

	public function __construct(CartService $cartService, CartProductService $cartProductService){
        $this->cartService = $cartService;
        $this->cartProductService = $cartProductService;
	}

	/**
	*
	*	Create order after user pays
	*	Request input: userId, transactionId, amount
	*
	**/
	public function createOrder($request){
        // Creates a new order entry for either guest or user
        if ($request->has('userId')) {
            $order = Order::create([
                'user_id' => $request->userId,
                'transaction_id' => $request->transactionId,
                'amount' => $request->amount,
                'status' => 'processing'
            ]);

            // Gets cart ID of user
            $cart = $this->cartService->getCart('user', $request->userId);
        } else {
            $order = Order::create([
                'session_id' => $request->sessionId,
                'transaction_id' => $request->transactionId,
                'amount' => $request->amount,
                'status' => 'processing'
            ]);

            // Gets cart ID of guest
            $cart = $this->cartService->getCart('guest', $request->sessionId);
        }

        // Get cart products using user's/guest's cart ID
        $cartProducts = $this->cartProductService->retrieveCartProducts($cart);

        // Add each product to order product table and remove from cart product table
        foreach($cartProducts as $cartProduct) {
            $orderProduct = OrderProduct::create([
                'order_id' => $order->id,
                'product_code' => $cartProduct->product_code,
                'quantity' => $cartProduct->quantity
            ]);

            $this->cartProductService->delete($cartProduct);
        }

        return success("Order created");
    }

	public function transform($order){
		return [
			'id' => $order->id,
			'user_id' => $order->user_id,
			'transaction_id' => $order->transaction_id,
            'amount' => $order->amount,
            'status' => $order->status
		];
	}
}
