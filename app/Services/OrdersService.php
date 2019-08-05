<?php

namespace App\Services;

use App\Order;
use App\OrderProduct;
use App\Services\TransformerService;
use App\Services\CartService;
use App\Services\CartProductService;
use App\Services\ProductsService;
use Session;
use Illuminate\Http\Request;


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

    public function index($request){
		$sort = $request->sort ? $request->sort : 'created_at';
		$order = $request->order ? $request->order : 'desc';
        $limit = $request->limit ? $request->limit : 10;
		$offset = $request->offset ? $request->offset : 0;
		$query = $request->search ? $request->search : '';

		$order = Order::where('transaction_id', 'like', "%{$query}%")->orderBy($sort, $order);
		$listCount = $order->count();

		$order = $order->limit($limit)->offset($offset)->get();

		return respond(['rows' => $order, 'total' => $listCount]);
    }
    
    public function update($request, $order){
        $order->user_id = $request->user_id;
        $order->session_id = $request->session_id;
        $order->transaction_id = $request->transaction_id;
        $order->amount = $request->amount;
        $order->status = $request->status;
		$order->save();

		Session::flash('success', 'The order was successfully saved!');
        return redirect()->route($this->path . 'index');
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
                'product_id' => $cartProduct->product_id,
                'quantity' => $cartProduct->quantity
            ]);

            $this->cartProductService->delete($cartProduct);
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
                $products[] = $this->productsService->retrieveProduct($orderProduct);
            }

            $order['items'] = $products;
            $ordersList[] = $order;

            // Clearing the products array after appending it to order array
            $products = array();
        }

        return $ordersList;
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
