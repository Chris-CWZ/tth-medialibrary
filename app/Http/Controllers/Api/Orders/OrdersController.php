<?php

namespace App\Http\Controllers\Api\Orders;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrdersService;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller {
	protected $ordersService;

	public function __construct(OrdersService $ordersService){
		$this->ordersService = $ordersService;
    }
    
	public function createOrder(Request $request){
		$validator = Validator::make($request->all(), [
            'userId' => 'required_without:sessionId|integer',
            'sessionId' => 'required_without:userId|string',
			'transactionId' => 'required|string|unique:orders,transaction_id',
			'amount' => 'required|numeric'
        ]);
        
        if ($validator->fails()) {
			return validationError();
		} else {
            return $this->ordersService->createOrder($request);
		}
    }
    
    public function getOrders(Request $request){
        $validator = Validator::make($request->all(), [
            'userId' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return validationError();
        } else {
            return $this->ordersService->getUserOrders($request);
        }
    }
}
