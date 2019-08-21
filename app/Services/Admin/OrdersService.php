<?php

namespace App\Services\Admin;

use Illuminate\Http\Request;
use App\Order;
use App\OrderStock;
use App\Stock;
use App\Promotion;
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
		
		$orderStocks = OrderStock::where('order_id', $order['id'])->get();

		foreach($orderStocks as $orderStock) {
			$stocks[] = Stock::find($orderStock->stock_id);
			$products[] = Stock::find($orderStock->stock_id)->product;
		}

		for ($i = 0; $i < count($orderStocks); $i++) {
			$totals[] = $products[$i]['price'] * $orderStocks[$i]['quantity'];
		}

		$promotion = Promotion::where('code', $order['promo_code'])->first();

		return view($this->path . 'show', ['order' => $order, 'orderStocks' => $orderStocks, 'stocks' => $stocks, 'products' => $products, 'totals' => $totals, 'promotion' => $promotion]);
	}
	
	public function update($request, $order){
		$order->status = $request->status;
		$order->save();

		Session::flash('success', 'The order was successfully saved!');
		return redirect()->route($this->path . 'index');
	}

	public function transform($order){
		return [
			'id' => $order->id,
			'user_id' => $order->user_id,
			'session_id' => $order->session_id,
			'payment_method' => $order->payment_method,
			'transaction_id' => $order->transaction_id,
			'sub_total' => $order->sub_total,
			'grand_total' => $order->grand_total,
			'status' => $order->status,
			'promo_code' => $order->promo_code
		];
	}
}
