<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Product;
use App\Stock;
use App\ProductUser;
use DB;

class ProductsService {
	public function retrieveProductsList($request){
		$sort = $request->sort ? $request->sort : 'created_at';
		$order = $request->order ? $request->order : 'desc';

		$query = Product::where('vendor', 'trp')->orderBy($sort, $order);

		if ($request->has('filter')) {
			$products = $query->whereBetween($request->filter, [$request['min'], $request['max']])->paginate(10);
		} else{
			$products = $query->paginate(10);
		}

		foreach ($products as $product) {
			$bookmarked = ProductUser::where('product_id', $product->id)->where('user_id', $request->userId)->first();

			if($bookmarked){
				$product['bookmarked'] = true;
			}else{
				$product['bookmarked'] = false;
			}
		}

		return respond($products);
	}

	public function transform($product){
		return [
			'id' => $product->id,
			'name' => $product->name,
			'price' => $product->price,
			'category' => $product->category,
			'product_details' => $product->product_details,
			'brand' => $product->brand,
			'care' => $product->care,
			'vendor' => $product->vendor
		];
	}
}