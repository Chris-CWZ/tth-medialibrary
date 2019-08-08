<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Services\TransformerService;
use Session;

class OrdersService extends TransformerService{
	
	protected $path = 'admin.orders.';

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

	public function show($order){
		$order = $this->transform($order);
		
		$orderProducts = OrderProduct::where('order_id', $order['id'])->get();

		foreach($orderProducts as $orderProduct) {
			$products[] = Product::find($orderProduct->product_id);
		}

		for ($i = 0; $i < count($orderProducts); $i++) {
			$totals[] = $products[$i]['price'] * $orderProducts[$i]['quantity'];
		}

		return view($this->path . 'show', ['order' => $order, 'orderProducts' => $orderProducts, 'products' => $products, 'totals' => $totals]);
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
