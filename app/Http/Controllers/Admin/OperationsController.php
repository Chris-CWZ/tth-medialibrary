<?php

namespace App\Http\Controllers\Admin;

use App\Operation;
use App\Services\Admin\OperationsService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OperationsController extends Controller{

	protected $operationsService;

	public function __construct(OperationsService $operationsService){
		$this->operationsService = $operationsService;
	}

	public function calendar() {
		return $this->operationsService->calendar();
	}
}
