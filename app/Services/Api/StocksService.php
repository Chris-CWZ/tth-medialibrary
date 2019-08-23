<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Stock;

class StocksService {
	public function getStock($request){
		$stock = Stock::where('product_id', $request->productId)->where('colour', $request->colour)->where('size', $request->size)->where('stock', '!=', 0)->first();
		return $stock;
    }

    public function colours($request){
		$colours = Stock::select('colour')->where('product_id', $request->productId)->distinct()->get();
		$coloursArray = [];		

		if($colours) {
			foreach($colours as $colour) {
				$coloursArray[] = $colour['colour'];
			}
		}

		return respond($coloursArray);
    }
    
    public function sizes($request){
		$sizes = Stock::select('size')->where('product_id', $request->productId)->where('colour', $request->colour)->distinct()->get();
		$sizesArray = [];

		if($sizes) {
			foreach($sizes as $size) {
				$sizesArray[] = $size['size'];
			}
		}

		return respond($sizesArray);
	}
}