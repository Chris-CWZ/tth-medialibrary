<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Promotion;
use App\Cart;
use App\BundledProductPromotion;
use App\UserPromotion;
use Carbon\Carbon;
use App\Services\Api\CartProductService;
use App\Services\Api\ProductsService;

class PromotionsService{
    protected $cartProductService;
	protected $productsService;

	public function __construct(CartProductService $cartProductService, ProductsService $productsService){
		$this->cartProductService = $cartProductService;
		$this->productsService = $productsService;
	}

	public function applyPromoCode($request){
        $promotion = $this->checkValidity($request->promoCode);

        if($promotion == null) {
            return errorResponse('Promo code does not exist or has expired');
        }

        // Checking if user has reached promo usage limit
        if($promotion->usage_limit != null) {
            if($request->has('userId')) {
                $userPromotions = UserPromotion::where('user_id', $request->userId)->where('promo_code', $promotion->code)->get();

                if(count($userPromotions) == $promotion->usage_limit) {
                    return errorResponse('You have reached the limit for using this promo code');
                }
            } else {
                return errorResponse('Please login or create an account to use this code');
            }
        }

        // Getting user's cart
        $cart = $this->getCart($request);

        // Check user's cart requirement
        $response = $this->checkCartRequirement($promotion, $cart);

        if($response->status() == 200) {
            $cartTotal = $this->calculateDiscount($cart, $promotion);
            Cart::where('id', $cart->id)->update(['promo_code' => $promotion->code, 'grand_total' => $cartTotal]);
        }

        return $response;
    }

    public function checkCartRequirement($promotion, $cart) {
        // Checking the type of promo
        if($promotion->type == 'bundled') {
            $cartProductsArray = $this->cartProductService->getCartProducts($cart);
            
            foreach($cartProductsArray as $cartProduct) {
                $names[] = $cartProduct['product']['name'];
            }

            $bundledProducts = BundledProductPromotion::where('promotion_id', $promotion->id)->get();

            foreach($bundledProducts as $bundledProduct) {
                $product = $this->productsService->retrieveProduct($bundledProduct->product_id);
                $productNames[] = $product->name;
            }

            $cartBundle = array_values(array_unique($names, SORT_STRING));
            $productBundle = array_values(array_unique($productNames, SORT_STRING));

            if($this->consistsOfTheSameValues($productBundle, $cartBundle)) {
                return success('Successfully applied promo code');
            }

            return errorResponse('Products in cart do not meet promotion requirements');
        } else {
            // Checking if cart amount meets promotion minimum spending amount
            if($cart->sub_total < $promotion->min_spending) {
                return errorResponse('Cart does not meet minimum spending requirement');
            } else {
                return success('Successfully applied promo code');
            }
        }
    }

    public function calculateDiscount($cart, $promotion) {
        if($promotion->discount_amount == null) {
            $discount = $cart->sub_total * $promotion->discount_percentage;

            if($promotion->cap_amount != null) {
                if($discount > $promotion->cap_amount) {
                    $cartTotal = $cart->sub_total - $promotion->cap_amount;
                } else {
                    $cartTotal = $cart->sub_total * (1 - $promotion->discount_percentage);
                }
            } else {
                $cartTotal = $cart->sub_total * (1 - $promotion->discount_percentage);
            }
            
        } else {
            $cartTotal = $cart->sub_total - $promotion->discount_amount;
        }

        return $cartTotal;
    }

    public function removePromoCode($request) {
        $cart = $this->getCart($request);
        $cart->promo_code = null;
        $cart->grand_total = $cart->sub_total;
        $cart->save();
        return success('Successfully removed promo code');
    }

    public function checkValidity($promoCode) {
        $currentDate = Carbon::now()->toDateTimeString();
        $promotion = Promotion::where('code', $promoCode)->where('start_date', '<=', $currentDate)->where('expiry_date', '>=', $currentDate)->first();
        return $promotion;
    }

    public function consistsOfTheSameValues(array $a, array $b) {
        // check size of both arrays
        if (count($a) !== count($b)) {
            return false;
        }

        foreach ($b as $key => $bValue) {
            // check that expected value exists in the array
            if (!in_array($bValue, $a, true)) {
                return false;
            }

            // check that expected value occurs the same amount of times in both arrays
            if (count(array_keys($a, $bValue, true)) !== count(array_keys($b, $bValue, true))) {
                return false;
            }
        }

        return true;
    }

    public function getCart($request) {
        if($request->has('userId')) {
            $cart = Cart::where('user_id', $request->userId)->first();
        } else {
            $cart = Cart::where('session_id', $request->sessionId)->first();
        }

        return $cart;
    }
}
