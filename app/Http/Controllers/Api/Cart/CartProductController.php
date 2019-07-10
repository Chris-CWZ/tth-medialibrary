<?php

namespace App\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartProductService;


class CartProductController extends Controller{

	protected $cartProductService;

	public function __construct(CartProductService $cartProductService){
		$this->cartProductService = $cartProductService;
	}

  public function getCartProducts(Request $request){
    return "test";
    // return $this->cartProductService->getCartProducts($request);
  }

  // /**
  //  * Store a newly created resource in storage.
  //  *
  //  * @param  \Illuminate\Http\Request  $request
  //  * @return \Illuminate\Http\Response
  //  */
  // public function store(Request $request){
	// 	$cart = $this->cartServices->cart();
	// 	return $this->cartItemServices->store($request, $cart);
  // }


  // /**
  //  * Remove the specified resource from storage.
  //  *
  //  * @param  \App\Cart  $cart
  //  * @param  \App\CartItem  $cartItem
  //  * @return \Illuminate\Http\Response
  //  */
  // public function destroy(Cart $cart, Item $cartItem){
  //   return $this->cartItemServices->delete($cartItem);
  // }
}
