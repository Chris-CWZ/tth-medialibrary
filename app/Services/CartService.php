<?php

namespace App\Services;

use App\Cart;
use App\Item;
use App\Services\TransformerService;
use App\Services\AuthService;
use App\Services\CartItemsService;
use Illuminate\Http\Request;

class CartService extends TransformerService{

	protected $cartItemsService;
	protected $authService;

	public function __construct(CartItemsService $cartItemsService,
															AuthService $authService){
		$this->cartItemsService = $cartItemsService;
		$this->authService = $authService;
	}


	/**
	*
	*	Get Or Create Users Cart
	*
	**/
	public function cart($type = 'normal'){
		$dbID = $this->getDBIdentity();
		$cart = $this->getOrCreateCart($dbID);

		$sessionID = $this->getSessionIdentity();
		$sessionCart = $this->getCart($sessionID);

		if ($sessionCart && $cart) {
			$cart = $this->mergeCarts($cart, $sessionCart);
		}elseif ($sessionCart) {
			$cart = $sessionCart;
		}elseif (!$cart) {
			$cart = $this->getOrCreateCart($sessionID);
		}

		if ($type == 'json') {
			return respond($this->transform($cart));
		}
		return $cart;
	}


	/**
	*
	*	get or create a cart based on the given id [session or db]
	*
	**/
	private function getOrCreateCart($id){
		$cart = Cart::where('user_id', $id)->first();

		if (!$cart && $id != null) {
			$cart = Cart::create([
				'user_id' => $id
			]);
		}

		return $cart;
	}


	/**
	*
	*	get a cart based on the given id [session or db]
	*
	**/
	private function getCart($id){
		return Cart::where('user_id', $id)->first();
	}

	
	/**
	*
	*	Merge Users Session Cart with database cart
	*
	**/
	private function mergeCarts($cart, $sessionCart){
		Item::where('owner_id', $sessionCart->id)->update([
			'owner_id' => $cart->id
		]);
		$sessionCart->delete();
		$this->eraseSessionIdentity();

		return $cart;
	}


	/**
	*
	*	get the logged in user id
	*
	**/
	private function getDBIdentity(){
		return current_user() ? current_user()->id : null;
	}


	/**
	*
	*	get the session id created for the non-logged in user
	*
	**/
	private function getSessionIdentity(){
		$identity = session('identity');

		if (!session()->has('identity')) {
			$identity = md5("Session" . time() . "Session");
			session(['identity' => $identity]);
		}

		return $identity;
	}

	private function eraseSessionIdentity(){
		if (session()->has('identity')) {
			session()->forget('identity');
		}
	}


	public function transform($cart){
		return [
			'id' => $cart->id,
			'user_id' => $cart->user_id,
			'items' => $this->cartItemsService->transformItems($cart)
		];
	}
}
