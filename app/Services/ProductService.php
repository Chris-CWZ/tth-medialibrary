<?php

namespace App\Services;

use App\Product;
use Illuminate\Http\Request;

class ProductService {
    /**
	*
	*	Retrieve products
	*	Request input: sort/filter(optional)
	*
	**/
    public function retrieveProductsList($request){
        
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
}