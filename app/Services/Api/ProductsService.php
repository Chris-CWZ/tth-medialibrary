<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Product;
use App\ProductUser;

class ProductsService {
	/**
	*
	*	Retrieve product's id based on their selected variance (size/color)
	*	Request input: name, size, colour
	*
	**/
	public function getProduct($request){
		// Checks if product still in stock
		$product = Product::where('name', $request->name)->where('colour', $request->colour)->where('size', $request->size)->where('vendor', 'trp')->where('stock', '!=', 0)->first();
		return $product;
	}

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

		$query = Product::where('vendor', 'trp')->where('stock', '!=', 0)->orderBy($sort, $order);

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

	/**
	*
	*	Retrieve products based on product_id
	*
	**/
	public function retrieveProduct($id){
		$product = Product::where('id', $id)->first();
		return $product;
	}

	/**
	*
	*	Retrieve a particular product's colour
	*   Request: name
	*
	**/
	public function colours($request){
		$colours = Product::select('colour')->where('name', $request['name'])->where('vendor', 'trp')->distinct()->get();
		
		foreach($colours as $colour) {
			$coloursArray[] = $colour['colour'];
		}

		return respond($coloursArray);
	}

	/**
	*
	*	Retrieve a particular product's size based on their name and colour selected
	*   Request: name, colour
	*
	**/
	public function sizes($request){
		$sizes = Product::select('size')->where('name', $request->name)->where('colour', $request->colour)->where('vendor', 'trp')->distinct()->get();
		
		foreach($sizes as $size) {
			$sizesArray[] = $size['size'];
		}

		return respond($sizesArray);
	}

	public function transform($product){
    return [
		'id' => $product->id,
		'name' => $product->name,
		'price' => $product->price,
		'category' => $product->category,
		'colour' => $product->colour,
		'size' => $product->size,
		'product_code' => $product->product_code,
		'product_details' => $product->product_details,
		'brand' => $product->brand,
		'care' => $product->care,
		'vendor' => $product->vendor,
		'stock' => $product->stock,
    ];
  }
}