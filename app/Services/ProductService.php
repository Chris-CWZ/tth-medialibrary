<?php

namespace App\Services;

use App\Product;
use Illuminate\Http\Request;

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
        $product = Product::where('id', $cartProduct['product_id'])->first();
        return $product;
    }

    /**
	*
    *	Retrieve a particular product's colour
    *   Request: product_code
	*
	**/
    public function colours($request){
        $colours = Product::select('colour')->where('product_code', $request['product_code'])->distinct()->get();
        
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
        $sizes = Product::select('size')->where('product_code', $request['product_code'])->distinct()->get();
        
        foreach($sizes as $size) {
            $sizesArray[] = $size['size'];
        }

        return respond($sizesArray);
    }
}