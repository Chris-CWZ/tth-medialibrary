<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthenticationsService;
use Illuminate\Http\Request;

class AuthenticationsController extends Controller{
	
	protected $eventsService;

	public function __construct(AuthenticationsService $authenticationsService){
    $this->authenticationsService = $authenticationsService;
	}

	public function authentication() {
		$this->authenticationService->authentication();
	}
}
