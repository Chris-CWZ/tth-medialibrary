<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Services\Api\OrdersService;

class OrdersController extends Controller {
	protected $ordersService;

	public function __construct(OrdersService $ordersService){
		$this->ordersService = $ordersService;
	}
	
	public function createOrder(Request $request){
		$validator = Validator::make($request->all(), [
			'userId' => 'required_without:sessionId|integer',
			'sessionId' => 'required_without:userId|string',
			'transactionId' => 'required|string|unique:orders,transaction_id'
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

	public function getAddresses(Request $request){
		return $this->ordersService->getAddresses($request);
	}

	public function createAddress(Request $request){
		
	}
}
