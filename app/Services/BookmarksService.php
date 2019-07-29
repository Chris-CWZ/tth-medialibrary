<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Product;
use App\ProductUser;
use App\Services\ProductsService;

class BookmarksService {
	protected $productsService;

	public function __construct(ProductsService $productsService){
		$this->productsService = $productsService;
	}

	public function getBookmarkedProducts($request){
		$bookmarks = [];

		$productUsers = ProductUser::where('user_id', $request->userId)->get();

		foreach ($productUsers as $productUser) {
			$product = $this->productsService->transform($productUser->product);

			array_push($bookmarks, $product);
		}

		return $bookmarks;
	}

	public function productBookmark(Request $request){
		$product = Product::where('product_code', $request->productCode)->first();
		$existingProductUser = ProductUser::where('product_id', $product->id)->where('user_id', $request->userId)->first();

		if(!$existingProductUser){
			$productUser = new ProductUser;
			$productUser->product_id = $product->id;
			$productUser->user_id = $request->userId;
			$productUser->save();

			return success('Bookmark added for product');
		}else{
			$existingProductUser->delete();

			return success('Bookmark removed for product');
		}
	}
}