<?php

namespace App\Http\Controllers\Api;

use App\Operations;
use App\Services\Api\OperationsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperationsController extends Controller{

	protected $operationsService;

	public function __construct(OperationsService $operationsService){
		$this->operationsService = $operationsService;
	}

	public function operatingHours(){
		return $this->operationsService->operatingHours();
	}
}
