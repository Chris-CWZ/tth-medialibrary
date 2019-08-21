<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\CartStock;
use App\Product;
use App\Stock;
use App\Services\TransformerService;
use App\Services\Api\StocksService;

class CartStockService extends TransformerService{

	protected $stocksService;

	public function __construct(StocksService $stocksService){
		$this->stocksService = $stocksService;
	}

	public function addStock($cart, $request){
		$stock = $this->stocksService->getStock($request);

		if($stock != null) {
			$duplicateCartStock = CartStock::where('cart_id', $cart->id)->where('stock_id', $stock->id)->first();

			if ($duplicateCartStock == null) {
				CartStock::create([
					'cart_id' => $cart->id,
					'stock_id' => $stock->id,
					'quantity' => $request->quantity
				]);
			} else {
				CartStock::where('cart_id', $cart->id)->where('stock_id', $stock->id)->increment('quantity', $request->quantity);
			}
		}

		return $stock;
	}

	public function getCartStocks($cart){
		$cartStocks = CartStock::where('cart_id', $cart->id)->get();
		$products = [];

		foreach($cartStocks as $cartStock){
			$product = Stock::find($cartStock->stock_id)->product;
			$product['quantity'] = $cartStock->quantity;
			$product['product_total'] = $product->price * $cartStock->quantity;

			$stock = Stock::find($cartStock->stock_id);
			$product['selected_stock'] = $stock;
			$products[] = $product;
		}

		return $products;
	}

	public function reduceQuantity($request, $cart, $product){
		$cartStock = CartStock::where('cart_id', $cart->id)->where('stock_id', $request->stockId)->first();

		if($cartStock->quantity != 1) {
			$cartStock->decrement('quantity', $request->quantity);
			$cart->sub_total -= $product->price * $request->quantity;
			return success("1 item has been removed from cart");
		}else{
			return $this->removeFromCart($request, $cart, $product);
		}
	}

	public function removeFromCart($request, $cart, $product){
		$cartStock = CartStock::where('cart_id', $cart->id)->where('stock_id', $request->stockId)->first();
		$cartStock->delete();
		$cart->sub_total -= $product->price * $cartStock->quantity;

		return success("Item removed from cart!");
	}

	public function transform($cartProduct){
		return [
			'id' => $cartProduct->id,
		];
	}
}
