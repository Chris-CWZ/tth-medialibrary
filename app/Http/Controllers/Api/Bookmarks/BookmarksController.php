<?php

namespace App\Http\Controllers\Api\Bookmarks;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductUser;
use App\Services\BookmarksService;
use Validator;


class BookmarksController extends Controller{
	

	public function __construct(BookmarksService $bookmarksService){
		$this->bookmarksService = $bookmarksService;
	}

	public function getBookmarkedProducts(Request $request){
		$validator = Validator::make($request->all(), [
			'userId' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->bookmarksService->getBookmarkedProducts($request);
		}
	}

	public function productBookmark(Request $request){
		$validator = Validator::make($request->all(), [
			'productCode' => 'required|integer',
			'userId' => 'required|integer'
		]);

		if ($validator->fails()) {
			return validationError();
		} else {
			return $this->bookmarksService->productBookmark($request);
		}
	}
}
