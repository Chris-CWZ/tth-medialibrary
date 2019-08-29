<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\PromotionsService;

class PromotionsController extends Controller {
	protected $promotionsService;

	public function __construct(PromotionsService $promotionsService){
		$this->promotionsService = $promotionsService;
    }
    
    public function applyPromoCode(Request $request){
        $validator = Validator::make($request->all(), [
            'userId' => 'integer|required_without:sessionId',
            'sessionId' => 'string|required_without:userId',
            'promoCode' => 'string|required'
        ]);
        
        if ($validator->fails()) {
			return validationError();
		} else {
			return $this->promotionsService->applyPromoCode($request);
		}
    }

    public function removePromoCode(Request $request){
        $validator = Validator::make($request->all(), [
            'userId' => 'integer|required_without:sessionId',
            'sessionId' => 'string|required_without:userId'
        ]);
        
        if ($validator->fails()) {
			return validationError();
		} else {
			return $this->promotionsService->removePromoCode($request);
		}
    }
}
