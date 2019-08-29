<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use App\Promotion;
use App\CartStock;
use App\Stock;
use App\Cart;
use App\BundledProductPromotion;
use App\UserPromotion;
use Carbon\Carbon;
use App\Services\Api\ProductsService;
use App\Services\Api\CartStockService;

class PromotionsService{
    protected $productsService;

	public function __construct(ProductsService $productsService){
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
        if($promotion->type == 'bundled') {
            $cartStocks = CartStock::where('cart_id', $cart->id)->get();
            
            foreach($cartStocks as $cartStock) {
                $stocks[]= Stock::find($cartStock->stock_id);
            }

            $bundledProducts = BundledProductPromotion::where('promotion_id', $promotion->id)->get();

            $result = $this->isProductMatchBundle($bundledProducts, $stocks);

            if(!$result) {
                return errorResponse('Products in cart do not meet promotion requirements');
            }

            return success('Successfully applied promo code');
        } else {
            // Checking if cart amount does not meet promotion minimum spending amount
            if($cart->sub_total < $promotion->min_spending) {
                return errorResponse('Cart does not meet minimum spending requirement');
            } else {
                return success('Successfully applied promo code');
            }
        }
    }

    public function isProductMatchBundle($bundledProducts, $stocks) {
        foreach($bundledProducts as $bundledProduct) {
            foreach($stocks as $stock) {
                if($bundledProduct['product_id'] == $stock['product_id']) {
                    $isMatched = true;
                    break;
                } else {
                    $isMatched = false;
                }
            }

            if(!$isMatched) {
                return false;
            }
        }

        return true;
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

    public function getCart($request) {
        if($request->has('userId')) {
            $cart = Cart::where('user_id', $request->userId)->first();
        } else {
            $cart = Cart::where('session_id', $request->sessionId)->first();
        }

        return $cart;
    }
}
