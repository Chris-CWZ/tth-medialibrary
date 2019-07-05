<?php

namespace App\Http\Controllers\Client\Cart;

use App\Item;
use App\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Client\CartServices\CartItemServices;
use App\Services\Client\CartServices\CartServices;


class CartItemsController extends Controller{

	protected $cartItemServices;
	protected $cartServices;


	public function __construct(CartItemServices $cartItemServices, CartServices $cartServices){
		$this->cartItemServices = $cartItemServices;
		$this->cartServices = $cartServices;
	}



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request){
		$cart = $this->cartServices->cart();
		return $this->cartItemServices->store($request, $cart);
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Cart  $cart
   * @param  \App\CartItem  $cartItem
   * @return \Illuminate\Http\Response
   */
  public function destroy(Cart $cart, Item $cartItem){
    return $this->cartItemServices->delete($cartItem);
  }
}
