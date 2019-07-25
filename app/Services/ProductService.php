<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Product;
use App\ProductUser;

class ProductService {
	/**
	*
	*	Retrieve products
	*	Request input: sort, order, filter, min, max
	*   Default: sort by latest
	*
	**/
	public function retrieveProductsList($request){
		$sort = $request->sort ? $request->sort : 'created_at';
		$order = $request->order ? $request->order : 'desc';

		$query = $products = Product::where('vendor', 'trp')->orderBy($sort, $order);

		if ($request->has('filter')) {
			$products = $query->whereBetween($request->filter, [$request['min'], $request['max']])->paginate(10);
		} else{
			$products = $query->paginate(10);
		}

		return respond($products);
	}

	/**
	*
	*	Retrieve products based on product_id
	*
	**/
	public function retrieveProduct($cartProduct){
		$product = Product::where('product_code', $cartProduct['product_code'])->first();
		return $product;
	}

	/**
	*
	*	Retrieve a particular product's colour
	*   Request: product_code
	*
	**/
	public function colours($request){
		$colours = Product::select('colour')->where('name', $request['name'])->distinct()->get();
		
		foreach($colours as $colour) {
			$coloursArray[] = $colour['colour'];
		}

		return respond($coloursArray);
	}

	/**
	*
	*	Retrieve a particular product's size
	*   Request: product_code
	*
	**/
	public function sizes($request){
		$sizes = Product::select('size')->where('name', $request['name'])->distinct()->get();
		
		foreach($sizes as $size) {
			$sizesArray[] = $size['size'];
		}

		return respond($sizesArray);
	}

	public function bookmark(Request $request){
		$product = Product::where('product_code', $request->productCode)->first();
		$existingProductUser = ProductUser::where('product', $product->id)->where('user', $request->userId)->first();

		if(!$existingProductUser){
			$productUser = new ProductUser;
			$productUser->product = $product->id;
			$productUser->user = $request->userId;
			$productUser->save();

			return success('Bookmark added for product');
		}else{
			$existingProductUser->delete();

			return success('Bookmark removed for product');
		}
	}
}