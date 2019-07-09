<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthenticationsController extends Controller{
	
	protected $eventsService;

	public function __construct(AuthService $authService){
    $this->authService = $authService;
	}

	public function authentication(Request $request) {
		$this->authService->authentication($request);
	}
}
