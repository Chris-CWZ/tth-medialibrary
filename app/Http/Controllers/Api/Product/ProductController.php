<?php

namespace App\Http\Controllers\Api\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ProductService;

class ProductController extends Controller {
    protected $productService;

	public function __construct(ProductService $productService){
		$this->productService = $productService;
    }
    
    /**
	*
	*	Retrieve products
	*	Request input: user_id/session_id, product_id, quantity
	*
	**/
    public function index(Request $request){
        return $this->productService->retrieveProductsList($request);
    }

    public function colours(Request $request){
        return $this->productService->colours($request);
    }

    public function sizes(Request $request){
        return $this->productService->sizes($request);
    }
}
